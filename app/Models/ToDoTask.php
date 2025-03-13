<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class ToDoTask extends Model
{
//    use SoftDeletes;

    protected array $dates = ['created_at', 'deleted_at'];
    protected $keyType = 'string';
    protected $primaryKey = 'uuid';
    public $incrementing = false;

    /**
     * Autopopulate uuid field
     * @return void
     */
    public static function boot() : void
    {
        parent::boot();
        self::creating( function($toDo) {
            $toDo->uuid = Str::uuid();
        });
    }

    public function getRouteKeyName() : string
    {
        return 'uuid';
    }

    /*
     * Each task can belong to one list
     *
     * Not currently used... but seems like something that would make this useful (multiple lists, multiple users...)
     */
    public function list() : BelongsTo
    {
        return $this->belongsTo(ToDoList::class);
    }

    protected function serializeDate(\DateTimeInterface $date) : string
    {
        return $date->diffForHumans();
    }
}
