<?php

namespace App\Http\Requests;

use Pearl\RequestValidate\RequestAbstract;

use App\Rules\TransactionPermissionRule;
use App\Rules\CheckPayerBalanceRule;

class TransactionRequest extends RequestAbstract
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(TransactionPermissionRule $permission, CheckPayerBalanceRule $balance): array
    {
        return [

            'value' => [
                'required',
                'numeric',
                'min:0.1'
            ],

            'payer' => [
                'required',
                'integer',
                'exists:users,id',
                $permission,
                $balance
            ],

            'payee' => [
                'required',
                'integer',
                'exists:users,id',
                'different:payer'
            ]

        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            //
        ];
    }
}
