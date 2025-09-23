<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str ;
use App\Models\Patiant ;

class PatiantFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'patiant_id',
        'filePath',
        'type'
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

    public function patiant()
    {
        return $this->belongsTo(Patiant::class,'patiant_id') ;
    }
}
