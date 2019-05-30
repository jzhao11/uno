<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model {
    protected $table = 'game';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'host_user_id', 'status'
    ];
}
