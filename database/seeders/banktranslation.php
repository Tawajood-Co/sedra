<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BankTranslation as Translation;

class banktranslation extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

            Translation::create([
                'bank_id'=>1,
                'locale' =>'en',
                 'name'  =>'nasir'
            ]);
            Translation::create([
                'bank_id'=>1,
                'locale' =>'ar',
                 'name'  =>'ناصر'
            ]);

            Translation::create([
                'bank_id'=>2,
                'locale' =>'en',
                 'name'  =>'qnp'
            ]);
            Translation::create([
                'bank_id'=>2,
                'locale' =>'ar',
                 'name'  =>'بنك قطر الدولي'
            ]);


            Translation::create([
                'bank_id'=>3,
                'locale' =>'en',
                 'name'  =>'cip'
            ]);
            Translation::create([
                'bank_id'=>3,
                'locale' =>'ar',
                 'name'  =>'بنك التجاري الدولي'
            ]);


    }
}
