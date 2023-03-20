<?php

namespace Database\Seeders;

use App\Models\UnitType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $insert = array(
            [
                'type' => 'apartment'
            ],
            [
                'type' => 'house'
            ]
        );

        UnitType::insert($insert);
    }
}
