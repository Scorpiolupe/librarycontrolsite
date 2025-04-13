<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookDetail extends Model
{
    protected $fillable = [
        'book_id',
        'barcode',
        'shelf_number'
    ];
    
    public function book(){
        return $this->belongsTo(Book::class);
    }
    public function getIsbnAttribute() {
        return $this->book->isbn;
    }
}
