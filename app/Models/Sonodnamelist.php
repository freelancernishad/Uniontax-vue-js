<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sonodnamelist extends Model
{
    use HasFactory;
    protected $fillable = [
        'bnname',
        'enname',
        'template',
    ];
}
