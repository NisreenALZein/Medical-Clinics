<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str ;


class Appointment extends Model
{
    use HasFactory;

    protected static function boot(){
        parent::boot() ;
        static::creating(function($model){
            $model->uuid = Str::uuid() ;
        });
        static::updating(function($model){
            if(empty($model->uuid)){
                $model->uuid = Str::uuid() ;
            }
        });
    } 
}
