<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $fillable=[
        'name','email','tel', 'password', 'is_admin','avatar','favori_kitap','favori_kategori'
    ];

    protected $hidden =[
        'password',
    ];

    public function isAdmin()
    {
        return (bool) $this->is_admin;
    }

}
