<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User ;
use Illuminate\Support\Str ;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        User::create([
            'uuid'=>Str::uuid(),
            'name' =>'NisreenAlZein' ,
            'email'=>'nisreen@gmail.com',
            'password'=> '123456789',
           'age' => 20,
            'gender'=>'fmale',
            'phone'=>'0995248865' ,
            'address'=>'homs',
            'role'=>'admin'
            
            ]);

            User::create([
                'uuid'=>Str::uuid(),
                'name' =>'Rami Ali' ,
                'email'=>'rami@gmail.com',
                'password'=> '1234512345',
               'age' => 22,
                'gender'=>'male',
                'phone'=>'0992833686' ,
                'address'=>'aleppo',
                'role'=>'assistance'
                
                ]);

                User::create([
                    'uuid'=>Str::uuid(),
                    'name' =>'Hala Ahmad' ,
                    'email'=>'hala55@gmail.com',
                    'password'=> '123123123',
                   'age' => 24,
                    'gender'=>'fmale',
                    'phone'=>'0955598147' ,
                    'address'=>'aleppo',
                    'role'=>'doctor'
                    
                    ]);

        
                    User::create([
                        'uuid'=>Str::uuid(),
                        'name' =>'basem farah' ,
                        'email'=>'basem54d@gmail.com',
                        'password'=> '147258369',
                       'age' => 25,
                        'gender'=>'male',
                        'phone'=>'0966625478' ,
                        'address'=>'homs',
                        'role'=>'receptionist'
                        
                        ]);
    }
}
