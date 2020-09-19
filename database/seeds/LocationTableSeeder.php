<?php

use Illuminate\Database\Seeder;
use App\Locations;

class LocationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = 10;
        factory(Locations::class, $count)->create();
    }
}
