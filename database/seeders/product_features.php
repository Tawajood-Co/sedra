<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductFeature;


class product_features extends Seeder
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
            ProductFeature::create([
                'product_id'=>$i+1
            ]);
        }
        for($i=0;$i<6;$i++){
            ProductFeature::create([
                'product_id'=>$i+1
            ]);
        }
    }
}
