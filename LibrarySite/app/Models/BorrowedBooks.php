<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BorrowedBooks extends Model
{
    protected $fillable=[
        'user_id','book_id','purchase_date','return_date','status','delay_day','late_fee'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

}
