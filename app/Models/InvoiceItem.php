<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class InvoiceItem extends Model
{
    use HasFactory, SoftDeletes; 

      /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'order_details';

    protected $fillable = [
        'order_id', 'product_id', 'quantity', 'cost', 'unit', 'amount'
    ];

    /**
     * Get the customer that owns the price_book.
     * @return App\Models\Invoice
     */

    public function Orders()
    {
        return $this->belongsTo(Invoice::class, 'order_id');
    }

      /**
     * Get the products for the order.
     */
    public function product(): HasMany
    {
        return $this->hasMany(Product::class, 'product_id');
    }

}
