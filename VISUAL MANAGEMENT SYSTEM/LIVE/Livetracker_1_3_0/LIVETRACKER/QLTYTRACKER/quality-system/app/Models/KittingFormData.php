<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KittingFormData extends Model
{
    use HasFactory;
    
    protected $table = 'QUALITY_PACK.dbo.KittingFormData';

    protected $fillable = [
        'ProcessOrderID',
        'cut_form_mach_parts',
        'bought_out_components',
        'fasteners_fixings',
        'site_pack',
        'sign_off_kitting',
        'comments_kitting',
        'cut_form_mach_parts', // Example file upload field
        'bought_out_components', // Example file upload field
        'fasteners_fixings', // Example file upload field
        'site_pack',
        'kitting_file', // Example file upload field
        // Add other kitting fields here
    ];
    
}

