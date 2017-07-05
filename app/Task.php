<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public $timestamps = false;
    protected $fillable = ['title', 'description', 'status', 'user_id'];

    public function user(){
        return $this->belongsTo('App\User');
    }

}
