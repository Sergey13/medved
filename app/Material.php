<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    public $table = 'materials';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 
        'created_at', 
        'name', 
        'count', 
        'balance_notification',
        'unit'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];
}
