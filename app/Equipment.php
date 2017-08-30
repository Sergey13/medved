<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    
    public $table = 'equipments';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'place_id', 'installation_date', 'pasport', 'inventory_number', 'document', 'unit'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];
    
    public function place() {
        
        return $this->hasOne('App\Place', 'id', 'place_id');
        
    }
    
    public function schedule() {
        
        return $this->hasMany('App\Schedule', 'equipment_id', 'id');
        
    }
    
    public function documents() {
        
        return $this->hasMany('App\Document', 'equipment_id', 'id');
    }
    
}
