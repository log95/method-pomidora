<?php

namespace App\Pomidor;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    const VALIDATION_RULES = [
        'pomidor_duration' => ['required', 'integer', 'between:1,360'],
        'short_rest_duration' => ['required', 'integer', 'between:1,360'],
        'long_rest_duration' => ['required', 'integer', 'between:1,360'],
        'long_rest_via_count_pomidors' => ['required', 'integer', 'between:1,10'],
        'need_sound_timer_finished' => ['required', 'boolean'],
    ];

    public $incrementing = false;

    protected $primaryKey = 'user_id';

    protected $fillable = [
        'user_id',
        'pomidor_duration',
        'short_rest_duration',
        'long_rest_duration',
        'long_rest_via_count_pomidors',
        'need_sound_timer_finished',
    ];

    protected $attributes = [
        'pomidor_duration' => 25,
        'short_rest_duration' => 3,
        'long_rest_duration' => 15,
        'long_rest_via_count_pomidors' => 4,
        'need_sound_timer_finished' => false,
    ];
}
