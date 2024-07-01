<?php

namespace App\Models;

use App\Events\VoteCreated;
use App\Events\VoteDeleted;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dispatchesEvents = [
        'deleted' => VoteDeleted::class,
        'created' => VoteCreated::class,
    ];
}
