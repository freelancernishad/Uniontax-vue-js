<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VillageCourt extends Model
{
    use HasFactory;

    protected $fillable = [
        'district',
        'upazila',
        'mouza',
        'subject',
        'medium',
        'rs_bs',
        'khatian_no',
        'dag_no',
        'land_amount',
        'amount_type',
        'total_khatian_land',
        'total_land_amount',
        'total_land_in_words',
        'applicant_name',
        'applicant_father_husband_name',
        'applicant_address',
        'applicant_mobile',
        'applicant_email',
        'applicant_nid_no',
        'applicant_photo',
        'applicant_signature',
        'representative_name',
        'representative_father_husband_name',
        'representative_address',
        'representative_mobile',
        'representative_email',
        'representative_age',
        'representative_relationship',
        'representative_photo',
        'representative_signature',
        'document',
        'miscaseType',
        'status', // Add this line
    ];
}
