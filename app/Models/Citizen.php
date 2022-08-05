<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Citizen extends Model
{
    use HasFactory;
    protected $fillable = [
        'unioun_name',
        'name',
        'fathername',
        'mothername',
        'word',
        'vill',
        'post',
        'thana',
        'district',
        'nidno',
        'dobno',
        'dob',
        'holding',
    ];
}
