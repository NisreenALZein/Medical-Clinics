<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str ;
use App\Models\Plan ;
use App\Models\User ;
use App\Models\Payment ;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'user_id',
        'plan_id',
        'startDate',
        'endDate',
        'paymentGateway',
        'autoRenew',
        'status'
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

    public function plan()
    {
        return $this->belongsTo(Plan::class,'plan_id') ;
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id') ;
    }

    public function payments()
    {
     return $this->hasmany(Payment::class);
    } 
}
