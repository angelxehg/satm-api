<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Material extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'brand', 'model', 'description', 'quantity'
    ];

    public function tasks()
    {
        return $this->belongsToMany('App\Task');
    }

    protected $hidden = [
        'deleted_at'
    ];
}
