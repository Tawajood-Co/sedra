<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product as Productmodel;

class product extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        for($i=0 ; $i<3; $i++){
            Productmodel::create([
                'type'=>'woman',
                'price'=>120+$i,
                'count'=>50
             ]);
        }
        for($i=0 ; $i<3; $i++){
            Productmodel::create([
               'type'=>'man',
               'price'=>120+$i,
               'count'=>50
            ]);
        }
    }
}
