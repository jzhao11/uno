<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Record extends Model {
    protected $table = 'record';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'game_id', 'user_id', 'result'
    ];
}
