<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Product extends Model
{
    use HasFactory, SoftDeletes; 

    protected $fillable = [
        'name', 'unit', 'price', 'category_id','image'
    ];

    /**
     * Get the customer that owns the price_book.
     * @return App\Models\Employee
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

}
