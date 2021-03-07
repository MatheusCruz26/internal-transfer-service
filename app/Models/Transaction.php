<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;

    protected $table = "transactions";

    protected $fillable = [
        'payer',
        'payee',
        'value',
        'status'
    ];

    protected $visible = [
        'value',
        'status'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function payer()
    {
        return $this->belongsTo(User::class, 'payer', 'id');
    }

    public function payee()
    {
        return $this->belongsTo(User::class, 'payee', 'id');
    }
}
