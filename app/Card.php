<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Card extends Model {
    protected $table = 'card';
    public $timestamps = false;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'number', 'color', 'img'
    ];
}
