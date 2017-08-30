<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    public $table = 'store';

    const TYPE_INCOMING = 'incoming';
    const TYPE_EXPENSE = 'expense';

    public static $units = array(
        'peice' => 'шт',
        'meter' => 'м',
        'kilo'  => 'кг',
    );
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'created_at',
        'component_id',
        'tool_id',
        'equipment_id',
        'material_id',
        'date',
        'count',
        'performer_id',
        'type',
        'place_id'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    public static function getUnits()
    {
        return self::$units;
    }

    public function component()
    {

        return $this->belongsTo('App\Component', 'component_id', 'id');

    }

    public function equipment()
    {

        return $this->belongsTo('App\Equipment', 'equipment_id', 'id');

    }

    public function tool()
    {

        return $this->belongsTo('App\Tool', 'tool_id', 'id');

    }

    public function material()
    {

        return $this->belongsTo('App\Material', 'material_id', 'id');

    }

    public function performer()
    {

        return $this->belongsTo('App\Performer', 'performer_id', 'id');

    }

    public function place()
    {
        return $this->belongsTo('App\Place', 'place_id', 'id');
    }
}
