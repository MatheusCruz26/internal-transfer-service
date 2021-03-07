<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

use Exception;

use App\Interfaces\iUser;

class TransactionPermissionRule implements Rule
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
                return $user->type === 'client';
            }else{
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }

    public function message(): string
    {
        return "Shopkeepers cannot make transfers.";
    }
}