<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'author', 'img',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'currentOwner_id', 'id');
    }
}
