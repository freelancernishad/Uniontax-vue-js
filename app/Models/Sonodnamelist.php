<?php

namespace App\Models;

use App\Models\Sonod;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sonodnamelist extends Model
{
    use HasFactory;
    protected $fillable = [
        'bnname',
        'enname',
        'icon',
        'template',
        'sonod_fee',
    ];


     function sonods()
    {
        return $this->hasMany(Sonod::class, 'sonod_name', 'bnname')->where('stutus','=', 'Pending');
    }

//    public function sonodsRel(){
//         return $this->hasOne(Sonod::class, 'sonod_name', 'bnname');
//     }

}
