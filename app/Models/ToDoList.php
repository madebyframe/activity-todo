<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ToDoList extends Model
{
    use HasFactory;


    /*
     * Each List could have many tasks
     */
    public function tasks() : HasMany
    {
        return $this->hasMany(ToDoTask::class);
    }

    /*
     * We could also attach the list to a user... with a BelongsTo
     */
}
