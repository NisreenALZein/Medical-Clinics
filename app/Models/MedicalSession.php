<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str ;
use App\Models\Appointment ;
use App\Models\Patiant ;
use App\Models\User ;
use App\Models\Medicine ;
use App\Models\Procedure ;
use App\Models\Invoice ;


class MedicalSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'doctor_id',
        'patiant_id',
        'appointment_id',
        'complaint',
        'diagnoseis'
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


    public function appointment()
    {
        return $this->belongsTo(Appointment::class,'appointment_id') ;
    }

    public function patiants()
    {
        return $this->belongsTo(Patiant::class,'patiant_id') ;
    }

    public function doctors()
    {
        return $this->belongsTo(User::class,'doctor_id') ;
    }

    public function medicine()
   {
    return $this->hasone(Medicine::class) ;
   }

   public function procedure()
   {
    return $this->hasone(Procedure::class) ;
   }

   
   public function invoice()
   {
    return $this->hasone(Invoice::class) ;
   }
}
