<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NidImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_bengali',
        'name_english',
        'father_name',
        'mother_name',
        'date_of_birth',
        'nid_no',
        'village_road',
        'post_office',
        'blood_group',
        'place_of_birth',
        'issue_date',
        'postcode',
        'thana',
        'district',
        'front_attachment',
        'back_attachment',
    ];
}
