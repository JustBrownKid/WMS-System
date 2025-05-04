<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inbound extends Model
{
    //
    protected $fillable = [
        'sku', 'item_name', 'description', 'purchase_price', 'quantity',
        'expire_date', 'received_date', 'received_by', 'sell_price', 
        'supplier', 'warehouse_name', 'location', 'status', 'voucher_number', 'remarks'
    ];
}
