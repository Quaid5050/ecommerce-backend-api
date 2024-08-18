<?php

namespace App\Interfaces;

interface AuthRepositoryInterface
{
    public function registerWithCredentials(array $data);
    public function registerWithOAuth(array $data);
    public function findUserByCredentials($email);
}
