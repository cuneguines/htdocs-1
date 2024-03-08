<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class KittingCompleteData extends Model
{
    use HasFactory;

    protected $fillable = [
        'ProcessOrderID',
        'cut_form_mach_parts',
        'bought_out_components',
        'fasteners_fixings',
        'site_pack',
        'sign_off_kitting',
        'comments_kitting',
        'status',
        'quantity',
        // Add other fields as needed
    ];

    protected $table = 'QUALITY_PACK.dbo.KittingFormCompleteData';

}
