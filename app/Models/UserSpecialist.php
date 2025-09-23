<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str ;
use App\Models\Specialist ;
use App\Models\User ;

class UserSpecialist extends Model
{
    use HasFactory;

    protected $fillable = [
       'uuid',
       'doctor_id',
       'specialist_id'
    ];


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [

    ];

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

    public function doctor()
    {
        return $this->belongsTo(User::class,'doctor_id') ;
    }

    public function specialist()
    {
        return $this->belongsTo(Specialist::class,'specialist_id') ;
    }
}
