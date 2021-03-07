<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

use Exception;

use App\Interfaces\iUser;

class CheckPayerBalanceRule implements Rule
{
    private $user;

    public function __construct(iUser $user)
    {
        $this->user = $user;
    }

    public function passes($attribute, $value): bool
    {
        try {
            if($user = $this->user->find($value)){
                return $user->balance >= request()->value;
            }else{
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }

    public function message()
    {
        return "Insufficient balance to complete a transaction.";
    }
}