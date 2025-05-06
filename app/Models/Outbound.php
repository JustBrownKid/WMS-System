<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Outbound extends Model
{
    //
    protected $fillable = [
        'sku',
        'item_name',
        'description',
        'quantity',
        'dispatch_date',
        'dispatched_by',
        'recipient',
        'destination',
        'from_warehouse',  
        'from_location',
        'status',
        'reference_number',
        'remarks',
    ];
    
}
