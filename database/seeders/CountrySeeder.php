<?php

namespace Database\Seeders;

use App\Http\Controllers\CountryController;
use App\Models\Country;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        (new CountryController)->storeCountries();
//        Country::create([
//            'ar' => [
//                'name' => 'السعودية'
//            ],
//            'en' => [
//                'name' => 'Saudi Arabia'
//            ]
//        ]);

    } // end of run
}
