<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Component extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'brand', 'model', 'description', 'isRoot'
    ];

    public function machine()
    {
    	return $this->belongsTo('App\Machine');
    }

    public function tasks()
    {
    	return $this->hasMany('App\Task');
    }

    protected $hidden = [
        'deleted_at'
    ];
}
