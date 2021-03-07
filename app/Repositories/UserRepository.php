<?php

namespace App\Repositories;

use App\Interfaces\iUser;

use App\Models\User;

class UserRepository implements iUser
{
    private $user;

    public function __construct(User $user)
    {
        return $this->user = $user;
    }

    public function find(int $id): User
    {
        return $this->user->find($id);
    }

    public function withdrawBalance(int $id, float $value): bool
    {
        $user = $this->find($id);
        $user->balance -= $value;

        return $user->save();
    }

    public function increaseBalance(int $id, float $value): bool
    {
        $user = $this->find($id);
        $user->balance += $value;

        return $user->save();
    }

}