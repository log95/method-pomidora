<?php

namespace App\Pomidor;

use Illuminate\Database\Eloquent\Model;

class CompletedTasks extends Model
{
    const VALIDATION_RULES = [
        'title' => ['string', 'required_without:description', 'max:500'],
        'description' => ['string', 'required_without:title', 'max:1000'],
    ];

    protected $table = 'completed_tasks';

    protected $fillable = [
        'user_id',
        'title',
        'description',
    ];
}
