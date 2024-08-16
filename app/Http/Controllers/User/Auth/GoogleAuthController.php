<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;
use Nette\Utils\Random;

class GoogleAuthController extends Controller
{
    /* public function redirectToGoogle()
    {
    return Socialite::driver('google')->stateless()->redirect();

    }

    public function handleGoogleCallback()
    {

    $googleUser = Socialite::driver('google')->stateless()->user();
    $user = User::firstOrCreate(
    ['email' => $googleUser->getEmail()],
    ['name' => $googleUser->getName()]
    );

    // Auth::login($user);

    return response()->json(['token' => $user->createToken('User Access Token')->accessToken]);

    }*/

    public function redirectToGoogle(Request $request)
    {
        $redirectUri = $request->input('redirect_uri', 'http://localhost:3000');
        session(['redirect_uri' => $redirectUri]);

        return Socialite::driver('google')->stateless()->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
            $user = User::firstOrCreate(
                ['email' => $googleUser->getEmail()],
                ['name' => $googleUser->getName()]
            );

            $token = $user->createToken('User Access Token')->plainTextToken;

            $redirectUri = session('redirect_uri', 'http://localhost:3000');

            return redirect()->to($redirectUri . '?token=' . $token);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Authentication Failed'], 401);
        }
    }

    public function clientAuth(Request $request)
    {
        DB::beginTransaction();
        try {

            $googleToken = $request->input('token');
            $userData = $request->input('user');

            // Validate the Google token and user data here.
            // You can use a Google SDK to verify the token if necessary.

            // Example: Check if the user already exists in your database
            $user = User::where('email', $userData['email'])->first();

            if (!$user) {
                // Create a new user if not found
                $user = User::create([
                    'name' => $userData['name'],
                    'email' => $userData['email'],
                    'google_id' => $googleToken,
                ]);
            } else {
                // Revoke (delete) all existing tokens for this user
                //if in future m0bile app then? they will also remove their access token
                // $user->tokens()->delete();
            }

            // Generate an access token for the user
            $accessToken = $user->createToken('User Access Token')->accessToken;
            DB::commit();

            return response()->json([
                'user' => $user,
                'accessToken' => $accessToken,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error message' => $e,
                'error' => 'Authentication Failed',
                'message' => $request->all(),

            ], 401);
        }
    }

    public function test(Request $request)
    {
        $googleToken = $request->input('token');
        $clientId = $request->input("clientId");
        $userData = $request->input('user');

        // Validate the Google token and user data here.
        // You can use a Google SDK to verify the token if necessary.

        // Example: Check if the user already exists in your database
        $user = User::where('email', $userData['email'])->first();

        if (!$user) {
            // Create a new user if not found
            $user = User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'google_id' => $googleToken,
            ]);
        }

        // Generate an access token for the user
//       $accessToken = $user->createToken('UserAccessToken')->accessToken;
        // Generate token for the user

        // Revoke tokens only for the specified client
        $webClientId = "9cae09e1-d914-462c-b33c-d9e62e5326ca";
        $mobileClientId = "9caf6289-11a3-48af-92e4-5aac4d4befb4";
        //pick random from both using random function
        $clientId = $mobileClientId;
//        $tokens = $user->tokens()->where('client_id', $clientId)->get();
//        foreach ($tokens as $token) {
////            $token->delete();
//        }


        $token = $user->createToken('authToken', [], $clientId);
        $accessToken = $token->accessToken;

        return response()->json([
            'user' => $user,
//            'tokens' => $tokens,
            'accessToken' => $accessToken,
            'token_expiry' => $token->token->expires_at,

        ]);

    }

    public function logout(Request $request)
    {
        try {
            $request->user()->token()->delete();
            return response()->json([
                'message' => 'Successfully logged out',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error message' => $e,
                'error' => 'Authentication Failed',
                'message' => $request->all(),
            ], 401);
        }
    }
}
