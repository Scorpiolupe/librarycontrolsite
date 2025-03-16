<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookReview extends Model
{
    protected $fillable=['user_id','book_id','comment','comment_date'];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function book(){
        return $this->belongsTo(Book::class);
    }
}
