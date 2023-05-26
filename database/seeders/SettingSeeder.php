<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::create([
            'ar' => [
                'about_us' => 'من نحن',
                'terms'    => 'الشروط والاحكام',
                'policy'   => 'سياسية الاستخدام'
            ],
            'en' => [
                'about_us'  => 'About Us',
                'terms'     => 'Terms and Condition',
                'policy'    => 'Policy',
            ],
            'phone_contact' => '01140465989',
            'email_contact' => 'a@gmail.com'
        ]);
    }
}
