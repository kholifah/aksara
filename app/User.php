<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPassword;

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


    public function validate($data)
    {
        if ($this->id) {
            if (isset($data['password']) || isset($data['password_confirmation']))
                $rules = [
                    'name' => 'required|string',
                    'email' => 'required|email|unique:users' . ($this->id ? ",id,$this->id" : ''),
                    'password' => 'required|confirmed',
                    'password_confirmation' => 'required'
                ];
            else
                $rules = [
                    'name' => 'required|string',
                    'email' => 'required|email|unique:users' . ($this->id ? ",id,$this->id" : ''),
                ];
        } else {
            $rules = [
                'name' => 'required|string',
                'email' => 'required|unique:users|email',
                'password' => 'required|confirmed',
                'password_confirmation' => 'required'
            ];
        }

        return \Validator::make($data, $rules);
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }


    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }
}
