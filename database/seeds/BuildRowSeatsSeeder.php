<?php

use Illuminate\Database\Seeder;
use App\Models\TheaterSeats;

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
        TheaterSeats::insertIntoRowSeats();

    }
}
