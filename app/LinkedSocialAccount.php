<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LinkedSocialAccount extends Model
{
    protected $fillable = [
        'user_id',
        'provider_name',
        'provider_user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
