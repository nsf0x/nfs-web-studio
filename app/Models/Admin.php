<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $table = 'admins';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'email',
        'password_hash',
        'last_login_at',
    ];

    protected $hidden = [
        'password_hash',
    ];

    protected $casts = [
        'last_login_at' => 'datetime',
        'created_at'    => 'datetime',
    ];

    /**
     * Override for custom password column name.
     */
    public function getAuthPassword(): string
    {
        return $this->password_hash;
    }
}
