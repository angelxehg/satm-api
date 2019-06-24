<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Machine extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'brand', 'model', 'description', 'ubication'
    ];

    public function components()
    {
    	return $this->hasMany('App\Component');
    }

    protected $hidden = [
        'deleted_at'
    ];
}
