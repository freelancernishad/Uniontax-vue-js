<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxInvoice extends Model
{
    use HasFactory;

    protected $fillable = [
       'invoiceId',
       'holdingTax_id',
       'PayYear',
       'totalAmount',
       'status',
    ];
}
