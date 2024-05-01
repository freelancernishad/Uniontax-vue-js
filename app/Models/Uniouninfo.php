<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Uniouninfo extends Model
{
    use HasFactory;
    protected $fillable = [
        'full_name',
        'short_name_e',
        'short_name_b',
        'portal',
        'thana',
        'district',
        'web_logo',
        'sonod_logo',
        'c_signture',
        'c_name',
        'c_type',
        'c_email',
        'socib_name',
        'socib_signture',
        'socib_email',
        'format',
        'u_image',
        'u_description',
        'u_notice',
        'u_code',
        'u_code',
        'contact_email',
        'google_map',
        'defaultColor',
        'payment_type',
        'AKPAY_MER_REG_ID',
        'AKPAY_MER_PASS_KEY',
        'smsBalance',
        'nidServicestatus',
        'nidService',
        'status',
    ];
}
