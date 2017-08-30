<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    public $table = 'documents';
    
     protected $fillable = [
        'name', 'equipment_id', 'type', 'created_at', 'updated_at', 'link'
    ];
}
