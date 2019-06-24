<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title', 'description', 'priority', 'dueDate', 'isComplete'
    ];

    public function component()
    {
    	return $this->belongsTo('App\Component');
    }

    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function materials()
    {
        return $this->belongsToMany('App\Material');
    }

    protected $hidden = [
        'deleted_at'
    ];
}
