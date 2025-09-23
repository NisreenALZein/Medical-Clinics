<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str ;
use App\Models\Subscription ;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'subscription_id',
        'amount',
        'transaction_id',
        'status',
        'paid_at'
       
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

    
    public function subscription()
    {
        return $this->belongsTo(Subscription::class,'subscription_id') ;
    }
}
