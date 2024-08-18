<?php


namespace App\Traits;

use App\Enums\AuthType;
use App\Http\Resources\AuthCredentialResource;
use App\Http\Resources\AuthProviderResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
trait ApiTokenTrait
{
    protected function createTokenResponse($user, $message, array $scopes = []): JsonResponse
    {
        $clientId = request()->header('client-id');
        $token = $user->createToken('authToken', $scopes, $clientId);

        $accountResource = match ($user->auth_type) {
            AuthType::CREDENTIALS->value => new AuthCredentialResource($user->authCredential),
            AuthType::OAUTH->value => new AuthProviderResource($user->authProvider),
            default => null,
        };
        return response()->json([
            'success' => true,
            'user' => new UserResource($user),
            'account' => $accountResource,
            'accessToken' => $token->accessToken,
            'token_expiry' => $token->token->expires_at,
            'client-id' => $clientId,
            'message' => $message,


        ], 200);
    }
    protected function deleteTokenResponse($message, $request) : JsonResponse
    {
        $request->user()->token()->delete();
        return response()->json([
            'success' => true,
            'message' => $message,
        ], 200);
    }
}


