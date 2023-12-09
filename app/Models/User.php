<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $primaryKey = 'user_id';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_firstname',
        'user_lastname',
    ];


    /**
     * @return HasMany
     */
    public function estates(): HasMany
    {
        return $this->hasMany(Estate::class, 'supervisor_user_id', 'user_id');
    }


    /**
     * @return HasMany
     */
    public function shifts(): HasMany
    {
        return $this->hasMany(UsersShift::class, 'user_id', 'user_id');
    }
}
