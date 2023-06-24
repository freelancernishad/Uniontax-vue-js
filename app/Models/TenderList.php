<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenderList extends Model
{
    use HasFactory;


    protected $fillable=[
       'union_name',
       'tender_id',
       'tender_type',
       'memorial_no',
       'tender_name',
       'description',
       'tender_word_no',
       'division',
       'district',
       'thana',
       'union',
       'govt_price',
       'form_price',
       'deposit_percent',
       'noticeDate',
       'form_buy_last_date',
       'tender_start',
       'tender_end',
       'tender_open',
       'tender_roles',
       'commette1phone',
       'commette1pass',
       'commette2phone',
       'commette2pass',
       'commette3phone',
       'commette3pass',
    ];

}
