<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = [
            (object)[
                'room_number' => 'A01',
                'type' => 'Single',
                'price' => 500000,
                'is_available' => true,
            ],
            (object)[
                'room_number' => 'A02',
                'type' => 'Double',
                'price' => 750000,
                'is_available' => false,
            ],
            (object)[
                'room_number' => 'B01',
                'type' => 'Single',
                'price' => 550000,
                'is_available' => true,
            ],
        ];

        return view('rooms.index', ['rooms' => $rooms]); 
    }
}

