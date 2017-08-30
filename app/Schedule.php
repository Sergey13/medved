<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    public $timestamps = false;
    
    public $table = 'schedule';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type_of_repair_id', 'equipment_id', 'date', 'performed'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];
    
    public function equipment() {
        
        return $this->belongsTo('App\Equipment', 'equipment_id', 'id');
        
    }
    
    public function type_of_repair() {
        
        return $this->belongsTo('App\TypeOfRepair', 'type_of_repair_id', 'id');
        
    }
    
    protected function getYears() {
        
        $dates = DB::table($this->table)->select('date')
                ->distinct()
                ->get();
        
        foreach($dates as $key => $date) {
            $dates[$key] = substr($date->date, 0, 4);
        }
        
        $dates = collect($dates);
        
        $years = $dates->unique();
        
        $years = $years->sortBy(function($item){
            return $item;
        });
        
        return $years;
    }
    
    protected function saveModels($models) {
        
        $result = DB::table($this->table)->insert($models);
        
        return true;
    }
}
