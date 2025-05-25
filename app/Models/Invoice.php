<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Invoice extends Model
{
    use HasFactory, SoftDeletes; 

      /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'orders';


    protected $fillable = [
        'order_number', 'user_id', 'customer_name', 'amount_total','order_date'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function invoice_items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

}
