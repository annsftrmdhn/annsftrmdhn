<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('rooms')->insert([
            [
                'room_number' => 'A01',
                'type' => 'Single',
                'price' => 500000,
                'is_available' => true,
            ],
            [
                'room_number' => 'A02',
                'type' => 'Single',
                'price' => 500000,
                'is_available' => false,
            ],
            [
                'room_number' => 'B01',
                'type' => 'Double',
                'price' => 750000,
                'is_available' => true,
            ],
        ]);
    }
}
