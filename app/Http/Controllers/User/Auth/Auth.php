<?php

namespace App\Http\Controllers\User\Auth;
use App\Http\Controllers\Controller;
use App\Models\AuthCredential;
use App\Models\AuthProvider;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
class Auth extends Controller
{
    public function register(Request $request)
    {
        try {
            if ($request->auth_type === 'credentials') {
                return $this->registerWithCredentials($request);
            } elseif ($request->auth_type === 'oauth') {
                return $this->registerWithOAuth($request);
            } else {
                return response()->json(['error' => 'Invalid authentication type'], 400);
            }
        } catch (Exception $e) {
            return response()->json(['error' => 'Registration failed: ' . $e->getMessage()], 500);
        }
    }

    public function registerWithCredentials(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email|unique:auth_credentials,email',//check if exist return
            'password' => 'required|min:8',
            'name' => 'required|string|max:255',
        ]);

        // Step 2: Create a new user and add the credentials
        $user = User::create([
            'name' => $validatedData['name'],
            'auth_type' => 'credentials',
        ]);

        AuthCredential::create([
            'user_id' => $user->id,
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
        ]);

        // Step 3: Return the user details
        return response()->json($user, 201);
    }


    public function  registerWithOAuth(Request $request)
    {
        $validatedData = $request->validate([
            'provider_name' => 'required|string',
            'provider_id' => 'required|string',
            'email' => 'nullable|email',
            'name' => 'required|string|max:255',
        ]);

        // Step 1: Check if the user already exists in auth_providers
        $authProvider = AuthProvider::where('provider_name', $validatedData['provider_name'])
            ->where('provider_id', $validatedData['provider_id'])
            ->first();

        if ($authProvider) {
            // User already exists, return the user details
            return response()->json($authProvider->user, 200);
        }

        // Step 2: Create a new user and add the OAuth details
        $user = User::create([
            'name' => $validatedData['name'],
            'auth_type' => 'oauth',
        ]);

        AuthProvider::create([
            'user_id' => $user->id,
            'provider_name' => $validatedData['provider_name'],
            'provider_id' => $validatedData['provider_id'],
            'email' => $validatedData['email'], // May be nullable
        ]);

        // Step 3: Return the user details
        return response()->json($user, 201);
    }

    public  function login(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            $authCredential = AuthCredential::where('email', $validatedData['email'])->first();

            if (!$authCredential || !password_verify($validatedData['password'], $authCredential->password)) {
                return response()->json(['error' => 'Invalid credentials'], 401);
            }
            $user = $authCredential->user;
            //get the clientId From headers
            $clientId = $request->header('client-id');
            $token = $user->createToken('authToken', [], $clientId);
            $accessToken = $token->accessToken;
            return response()->json([
                'user' => $user,
                'accessToken' => $accessToken,
                'token_expiry' => $token->token->expires_at,
                'client-id'=>$clientId,
            ]);

        }catch (Exception $e){
            return response()->json(['error' => 'Login failed: ' . $e->getMessage()], 500);
        }
    }

    public  function user(Request $request)
    {
        return response()->json($request->user(), 200);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->delete();
        return response()->json(['message' => 'Successfully logged out'], 200);
    }
}
