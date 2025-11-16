<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uid',
        'name',
        'role',
        'username',
        'phone',
        'withdraw_acc_number',
        'password',
        'withdraw_password',
        'amount',
        'status',
        'remember_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'withdraw_password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setPasswordAttribute($value)
    {
        if ($value) {
            $this->attributes['password'] = bcrypt($value);
        }
    }

    public function setWithdrawPasswordAttribute($value)
    {
        if ($value) {
            $this->attributes['withdraw_password'] = bcrypt($value);
        }
    }
    public function getAuthIdentifierName()
    {
        return 'username';
    }

    public function frozenAmount()
    {
        return $this->hasOne(FrozenAmount::class);
    }
    public function order()
    {
        return $this->hasMany(Order::class);
    }

}
