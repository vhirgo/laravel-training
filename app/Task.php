<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public $fillable = ['name', 'description', 'done_at'];

    public $dates = [
        'done_at',
    ];
}
