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
                'main_img' =>'woman_cloth.jpg',
                'price'=>120+$i,
                'count'=>50
             ]);
        }
        for($i=0 ; $i<3; $i++){
            Productmodel::create([
               'type'=>'man',
               'main_img' =>'man_cloth.jpg',
               'price'=>120+$i,
               'count'=>50
            ]);
        }
    }
}
