<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    protected $fillable = [
        'book_name',
        'author',
        'page_count',
        'category_id',
        'isbn',
        'publisher',
        'publish_year',
        'status'
    ];

    public $timestamps = false;
    
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
