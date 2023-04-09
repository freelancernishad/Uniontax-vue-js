<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CitizenInformation extends Model
{
    use HasFactory;

    protected $fillable = [
        'fullNameEN',
        'fathersNameEN',
        'mothersNameEN',
        'spouseNameEN',
        'presentAddressEN',
        'permenantAddressEN',
        'fullNameBN',
        'fathersNameBN',
        'mothersNameBN',
        'spouseNameBN',

        'presentAddressBN',
        'presentHolding',
        'presentVillage',
        'presentUnion',
        'presentPost',
        'presentPostCode',
        'presentThana',
        'presentDistrict',

        'presentdivision',
        'pr_region',
        'pr_Ward_For_Union_Porishod',
        'pr_add_mouza_Moholla',
        'pr_cc_Municipality',
        'pr_mouza_Moholla',
        'pr_village_Road',
        'pr_RMO',


        'permanentAddressBN',
        'permanentHolding',
        'permanentVillage',
        'permanentUnion',
        'permanentPost',
        'permanentPostCode',
        'permanentThana',
        'permanentDistrict',


        'permanentdivision',
        'pe_region',
        'pe_Ward_For_Union_Porishod',
        'pe_add_mouza_Moholla',
        'pe_cc_Municipality',
        'pe_mouza_Moholla',
        'pe_village_Road',
        'pe_RMO',



        'gender',
        'education',
        'religion',
        'nidFather',
        'nidMother',

        'profession',
        'dateOfBirth',

        'birthPlaceBN',
        'mothersNationalityBN',
        'mothersNationalityEN',
        'fathersNationalityBN',
        'fathersNationalityEN',
        'birthRegistrationNumber',


        'nationalIdNumber',
        'oldNationalIdNumber',
        'photoUrl',
    ];

}
