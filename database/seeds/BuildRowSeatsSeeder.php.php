<?php

use Illuminate\Database\Seeder;
use App\Models\TheaterSeats;
use Illuminate\Support\Facades\DB;

class BuildRowSeatsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $row_seats = TheaterSeats::buildAllSeats();
        foreach ($row_seats as $row =>$seats) {
            foreach ($seats as $seat) {
                DB::table('row_seats')->insert([
                    'row' => $row+1,
                    'seat' => $seat,
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
            }
        }
    }
}
