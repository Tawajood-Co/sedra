<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductFeatureTranslation;


class product_feature_translation extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        for ($i=0 ; $i<6 ;$i++){
            ProductFeatureTranslation::create([
               'product_feature_id'  => $i+1 ,
               'locale'              => 'ar' ,
               'feature'             =>  'color'  ,
               'value'               =>  'red'  ,
            ]);
        }

        for ($i=0 ; $i<6 ;$i++){
            ProductFeatureTranslation::create([
               'product_feature_id'  => $i+1 ,
               'locale'              => 'en' ,
               'feature'             =>  'اللون '  ,
               'value'               =>  'احمر'  ,
            ]);
        }

        for ($i=6 ; $i<12 ;$i++){
            ProductFeatureTranslation::create([
               'product_feature_id'  =>  $i+1 ,
               'locale'              =>  'ar' ,
               'feature'             =>  'material'  ,
               'value'               =>  'coton'  ,
            ]);
        }

        for ($i=6 ; $i<12 ;$i++){
            ProductFeatureTranslation::create([
               'product_feature_id'  => $i+1 ,
               'locale'              => 'en' ,
               'feature'             =>  'الماده'  ,
               'value'               =>  'قطن'  ,
            ]);
        }


    }
}
