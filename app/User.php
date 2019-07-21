<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function boot()
    {
        parent::boot();

        static::created(function ($user) {
            $user->profile()->create([
                'Name' => $user->name,
                'img' => 'profiles/no-photo.png',
                'BookCount' => 0
            ]);
        });
    }

    /* Returns the profile of the user
     *
     * @return Profile
     */
    public function profile()
    {
        return $this->hasOne(Profile::class, 'user_id', 'id');
    }


    public function books()
    {
        return $this->hasMany(Book::class, 'currentOwner_id', 'id')->orderBy('BookName', 'ASCE');
    }

    public function offers()
    {
        return $this->hasMany(TradeOffer::class, 'to_user_id', 'id');
    }

    public function offered()
    {
        return $this->hasMany(TradeOffer::class, 'from_user_id', 'id');
    }
}
