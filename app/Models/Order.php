<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'status', 'total', 'shipping_address', 'shipped_at'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity')->withTimestamps();
    }

    public function calculateTotal()
    {
        $total = $this -> products -> reduce(function ($carry, $product) {
            return $carry + ($product -> price * $product -> pivot -> quantity);
        }, 0);

        $this -> update(['total' => $total]);
    }
}
