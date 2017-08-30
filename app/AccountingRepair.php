<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountingRepair extends Model
{
    public $table = 'accounting_repair';
    
    
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 
        'created_at', 
        'performer_id', 
        'type_of_repair_id', 
        'schedule_id', 
        'equipment_id',
        'component_id',
        'date',
        'comment'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];
    
    
    public  function performer() {
        
        return $this->belongsTo('App\Performer', 'performer_id', 'id');
        
    }
    
    public  function equipment() {
        
        return $this->belongsTo('App\Equipment', 'equipment_id', 'id');
        
    }
    
    public function component() {
        
        return $this->belongsTo('App\Component', 'component_id', 'id');
        
    }


    public function type_of_repair() {
        
        return $this->belongsTo('App\TypeOfRepair', 'type_of_repair_id', 'id');
        
    }
    
    
    public function schedule() {
        
        return $this->belongsTo('App\Schedule', 'schedule_id', 'id');
    }
}
