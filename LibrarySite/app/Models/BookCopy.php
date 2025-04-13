<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookCopy extends Model
{
    protected $fillable = [
        'book_id',
        'barcode',
        'shelf_location',
        'condition',
        'status',
        'is_reference',
        'acquisition_date',
        'cover_image',
        'notes',
    ];

    protected static function booted()
    {
        static::creating(function ($copy) {
            if (empty($copy->barcode)) {
                $lastId = BookCopy::max('id') ?? 0;
                $nextId = $lastId + 1;
                $copy->barcode = 'BC-' . str_pad($nextId, 6, '0', STR_PAD_LEFT);
            }
        });
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
    public function stockHistory()
    {
        return $this->hasMany(StockHistory::class, 'copy_id');
    }
    public function getCoverImageUrlAttribute()
    {
        return $this->cover_image ? asset('storage/' . $this->cover_image) : null;
    }
}
