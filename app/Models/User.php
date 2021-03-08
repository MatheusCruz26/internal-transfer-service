<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class User extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "users";

    protected $fillable = [
        'name',
        'document',
        'email',
        'type',
        'balance'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $hidden = [
        'password'
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'payer', 'id');
    }

    public function setPasswordAttribute(string $password)
    {
        return $this->attributes['password'] = Hash::make($password);
    }
}
