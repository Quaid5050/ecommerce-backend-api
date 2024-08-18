<?php
namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use App\Models\AuthCredential;
use Illuminate\Support\Facades\DB;
use Exception;

class UserRepository implements UserRepositoryInterface
{
    public function createUser(array $data)
    {
        DB::beginTransaction();
        try {
            $user = User::create($data);
            DB::commit();
            return $user;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function findUserByEmail(string $email)
    {
        return AuthCredential::where('email', $email)->first();
    }
}
