<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Performer extends Model
{
    public $table = 'performers';
    
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'fio',
        'date_of_employment',
        'phone'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];
}
