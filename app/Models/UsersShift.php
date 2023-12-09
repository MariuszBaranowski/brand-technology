<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UsersShift extends Model
{
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'substitute_user_id',
        'temp_changes',
        'date_from',
        'date_to',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'temp_changes' => AsCollection::class,
        'date_from' => 'datetime',
        'date_to' => 'datetime',
    ];

    /**
     * @return HasOne
    */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'user_id', 'user_id');
    }

    /**
     * @return HasOne
     */
    public function substitute(): HasOne
    {
        return $this->hasOne(User::class, 'user_id', 'substitute_user_id');
    }
}
