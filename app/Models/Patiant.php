<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str ;
use App\Models\Appointment ; 
use App\Models\MedicalSession ;
use App\Models\PatiantFile ;

class Patiant extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'name',
        'email',
        'gender',
        'age',
        'phone',
        'address',
        'archived',
        'archived_at'
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

    public function appointments(){
        return $this->hasMany(Appointment::class) ;
    }

    public function sessions()
    {
     return $this->hasmany(MedicalSession::class);
    } 

    public function files(){
        return $this->hasMany(PatiantFile::class) ;
    }
}
