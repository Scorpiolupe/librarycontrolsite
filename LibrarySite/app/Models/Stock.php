<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $primaryKey = 'book_id';
    protected $fillable = ['book_id', 'quantity'];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
