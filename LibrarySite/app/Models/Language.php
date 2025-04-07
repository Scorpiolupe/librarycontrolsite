<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $fillable = [
        'name',
        'code'
    ];

    public $timestamps = false;

    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
