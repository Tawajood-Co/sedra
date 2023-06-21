<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductImg;

class product_imgs extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        for($i=0;$i<6;$i++){
            ProductImg::create([
                'product_id' =>$i+1,
                'img'        =>'img1.jpg'
            ]);
        }

        for($i=0;$i<6;$i++){
            ProductImg::create([
                'product_id'=>$i+1,
                'img'        =>'img2.jpg'

            ]);
        }
    }
}
