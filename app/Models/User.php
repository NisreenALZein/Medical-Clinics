<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str ;
use App\Models\Appointment ;
use App\Models\MedicalSession ;
use App\Models\UserSpecialist ;
use App\Models\Subscription ;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public const ROLE_ADMIN = 'admin';
    public const ROLE_DOCTOR = 'doctor';
    public const ROLE_ASSISTANT = 'assistance';
    public const ROLE_RECEPTIONIST = 'receptionist';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'name',
        'email',
        'password',
        'gender',
        'age',
        'phone',
        'address',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
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

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isDoctor(): bool
    {
        return $this->role === self::ROLE_DOCTOR;
    }

    public function isAssistant(): bool
    {
        return $this->role === self::ROLE_ASSISTANT;
    }

    public function isReceptionist(): bool
    {
        return $this->role === self::ROLE_RECEPTIONIST;
    }


    public function appointments(){
        return $this->hasMany(Appointment::class) ;
    }

    public function sessions()
    {
     return $this->hasmany(MedicalSession::class);
    } 

    public function userSpecialists()
    {
     return $this->hasmany(UserSpecialist::class);
    } 

    
    public function subscription()
   {
    return $this->hasone(Subscription::class) ;
   }

}
