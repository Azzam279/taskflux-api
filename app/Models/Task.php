<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model;

use MongoDB\Laravel\Eloquent\Model;

class Task extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'tasks';

    protected $primaryKey = '_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'title', 'description', 'status', 'priority', 'dueDate', 'ownerId',
    ];

    protected $casts = [
        'dueDate'    => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
