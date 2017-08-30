<?php

namespace App\Console\Commands;

use App\Component;
use App\Equipment;
use App\Material;
use App\Place;
use App\Store;
use App\Tool;
use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;

class MoveAllPlacesToTablePlaces extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'polar:move_places';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display an inspiring quote';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $equipments = Store::whereNotNull('equipment_id')
            ->whereType(Store::TYPE_EXPENSE)
            ->get();
        $components = Store::whereNotNull('component_id')
            ->whereType(Store::TYPE_EXPENSE)
            ->get();
        $materials = Store::whereNotNull('material_id')
            ->whereType(Store::TYPE_EXPENSE)
            ->get();
        $tools = Store::whereNotNull('tool_id')
            ->whereType(Store::TYPE_EXPENSE)
            ->get();
        foreach ($materials as $entity) {
            if (strlen($entity->to_place)) {
                $place = Place::whereName($entity->to_place)->first();
                if ($place) {
                    $entity->place_id = $place->id;
                } else {
                    $place = Place::create([
                        'name' => $entity->to_place
                    ]);
                    $entity->place_id = $place->id;
                }
                $entity->save();    
            }
        }
        print_r('material ok  ');

        foreach ($components as $entity) {
            if (strlen($entity->to_place)) {
                $place = Place::whereName($entity->to_place)->first();
                if ($place) {
                    $entity->place_id = $place->id;
                } else {
                    $place = Place::create([
                        'name' => $entity->to_place
                    ]);
                    $entity->place_id = $place->id;
                }
                $entity->save();
            }
        }
        print_r('component ok  ');

        foreach ($equipments as $entity) {
            if (strlen($entity->to_place)) {
                $place = Place::whereName($entity->to_place)->first();
                if ($place) {
                    $entity->place_id = $place->id;
                } else {
                    $place = Place::create([
                        'name' => $entity->to_place
                    ]);
                    $entity->place_id = $place->id;
                }
                $entity->save();
            }
        }
        print_r('equipment ok  ');

        foreach ($tools as $entity) {
            if (strlen($entity->to_place)) {
                $place = Place::whereName($entity->to_place)->first();
                if ($place) {
                    $entity->place_id = $place->id;
                } else {
                    $place = Place::create([
                        'name' => $entity->to_place
                    ]);
                    $entity->place_id = $place->id;
                }
                $entity->save();
            }
        }
        print_r('tool ok  ');
    }
}
