<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductTranslation;

class product_translations extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=0 ; $i<3; $i++){
            ProductTranslation::create([
                'locale'        =>'en',
                'name'          =>'glapia',
                'description'   =>'galbia made from coton',
                'product_id'    =>$i+1
             ]);
             ProductTranslation::create([
                'locale'        =>'ar',
                'name'          =>'جلابيه حريمي',
                'description'   =>'جلابيه حريمي شيك',
                'product_id'    =>$i+1
             ]);
        }
        for($i=3 ; $i<6; $i++){
            ProductTranslation::create([
                'locale'        =>'en',
                'name'          =>'glapia ',
                'description'   =>'galbia made from coton',
                'product_id'    =>$i+1
             ]);
             ProductTranslation::create([
                'locale'=>'ar',
                'name'          =>'جلابيه رجالي',
                'description'   =>'جلابيه رجالي شيك',
                'product_id'    =>$i+1
             ]);
        }
    }
}
