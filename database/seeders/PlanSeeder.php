<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Plan ;
use Illuminate\Support\Str ;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

            Plan::create([
                'name' => 'Starter',
                'price' => 300,
                'interval' => 'monthly',
                'maxUsers' => 1,
                'features' => ['حساب طبيب واحد'],
            ]);

            Plan::create([
                'name' => 'Pro',
                'price' => 400,
                'interval' => 'monthly',
                'maxUsers' => 3,
                'features' => ['حتى 3 مستخدمين + تقارير متقدمة  '],
            ]);

            Plan::create([
                'name' => 'Advanced',
                'price' => 500,
                'interval' => 'monthly',
                'maxUsers' => 6,
                'features' => ['حتى 6 مستخدمين + اشعارات + تخصيص'],
            ]);
            
    }
}
