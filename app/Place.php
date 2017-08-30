<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    public $table = 'places';
    
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    public static function getPlacesForSelect()
    {
        $places = Place::all()->toArray();

        $ids = array_column($places, 'id');

        array_push($ids, '');

        $names = array_column($places, 'name');

        array_push($names, 'Выберите место установки');

        return array_combine($ids, $names);
    }

}
