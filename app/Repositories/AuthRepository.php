<?php
namespace App\Repositories;

use App\Interfaces\AuthRepositoryInterface;
use App\Models\AuthCredential;
use App\Models\AuthProvider;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Enums\AuthType;
class AuthRepository implements AuthRepositoryInterface
{
    public function registerWithCredentials(array $data)
    {
        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $data['name'],
                'auth_type' => AuthType::CREDENTIALS->value,
            ]);

           AuthCredential::create([
                'user_id' => $user->id,
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
            ]);

            DB::commit();
            return $user;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function registerWithOAuth(array $data)
    {
        DB::beginTransaction();
        try {
            $authProvider = AuthProvider::where('provider_name', $data['provider_name'])
                ->where('provider_id', $data['provider_id'])
                ->first();

            if ($authProvider) {
                DB::commit();
                return $authProvider->user;
            }

            $user = User::create([
                'name' => $data['name'],
                'auth_type' => AuthType::OAUTH->value,
            ]);

            AuthProvider::create([
                'user_id' => $user->id,
                'provider_name' => $data['provider_name'],
                'provider_id' => $data['provider_id'],
                'email' => $data['email'],
            ]);
            DB::commit();
            return $user;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function findUserByCredentials($email)
    {
        return AuthCredential::where('email', $email)->first();
    }
}
