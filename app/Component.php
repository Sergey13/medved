<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    public $table = 'components';
    
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
    
    public function child() {
        
        return $this->hasMany('App\Component', 'parent_id', 'id');
        
    }
}
