<?php

namespace App\Http\Controllers\User;

use App\Enums\AuthType;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterCredentialsRequest;
use App\Http\Requests\RegisterOAuthRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\AuthCredentialResource;
use App\Http\Resources\AuthProviderResource;
use App\Http\Resources\UserResource;
use App\Interfaces\AuthRepositoryInterface;
use App\Repositories\AuthRepository;
use App\Traits\ApiResponseTrait;
use App\Traits\ApiTokenTrait;
use Illuminate\Http\Request;


use Exception;

class AuthController extends Controller
{
    use ApiResponseTrait, ApiTokenTrait;

    protected $authRepository;

    public function __construct(AuthRepositoryInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function registerWithCredentials(RegisterCredentialsRequest $request)
    {
        try {
            $user = $this->authRepository->registerWithCredentials($request->validated());
            return $this->createTokenResponse($user, 'User registered successfully');
        } catch (Exception $e) {
            return $this->errorResponse('Registration failed: ' . $e->getMessage());
        }
    }

    public function registerWithOAuth(RegisterOAuthRequest $request)
    {
        try {
            $user = $this->authRepository->registerWithOAuth($request->validated());
            return $this->createTokenResponse($user, 'OAuth successful');
        } catch (Exception $e) {
            return $this->errorResponse('OAuth registration failed: ' . $e->getMessage());
        }
    }

    public function login(LoginRequest $request)
    {
        try {
            $authCredential = $this->authRepository->findUserByCredentials($request->email);

            if (!$authCredential || !password_verify($request->password, $authCredential->password)) {
                return $this->errorResponse('Invalid credentials', [], 401);
            }

            $user = $authCredential->user;
            return $this->createTokenResponse($user, 'Login successful');
        } catch (Exception $e) {
            return $this->errorResponse('Login failed: ' . $e->getMessage(), [], 500);
        }
    }

    public function user(Request $request)
    {
        try {
            $user = $request->user();
            $accountResource = match ($user->auth_type) {
                AuthType::CREDENTIALS->value => new AuthCredentialResource($user->authCredential),
                AuthType::OAUTH->value => new AuthProviderResource($user->authProvider),
                default => null,
            };

            return $this->successResponse([
                    'user' => new UserResource($user),
                    'account' => $accountResource
                ], 'User details retrieved successfully'
            );
        } catch (Exception $e) {
            return $this->errorResponse('User details retrieval failed: ' . $e->getMessage(), [], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            return $this->deleteTokenResponse("Logout successfully", $request);
        }catch (Exception $e){
            return $this->errorResponse('Logout failed: ' . $e->getMessage(), [], 500);
        }
    }


}

