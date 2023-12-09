<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Estate extends Model
{
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'supervisor_user_id',
        'street',
        'building_number',
        'city',
        'zip',
    ];


    /**
     * @return HasOne
     */
    public function supervisor(): HasOne
    {
        return $this->hasOne(User::class, 'user_id', 'supervisor_user_id');
    }
}
