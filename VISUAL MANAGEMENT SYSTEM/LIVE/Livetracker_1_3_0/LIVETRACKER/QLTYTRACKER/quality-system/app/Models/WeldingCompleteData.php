<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class WeldingCompleteData extends Model
{
    use HasFactory;

    protected $fillable = [
        'ProcessOrderID',
        'weld_map_issued',
        'link_to_weld_map',
        'weld_procedure_qualification',
        'link_to_pqr',
        'weld_procedure_specifications',
        'link_to_wps',
        'welder_performance_qualification',
        'link_to_wpq',
        'welding_wire',
        'link_to_wire_certificate',
        'shielding_gas',
        'link_to_gas_data_sheet',
        'pre_weld_inspection',
        'inspection_during_welding',
        'post_weld_inspection',
        'sign_off_welding_complete',
        'comments_welding_complete',
        'status',
        'quantity',
        'sign_offw_c',
        // Add other fields as needed
    ];

    protected $table = 'QUALITY_PACK.dbo.WeldingCompleteData';
}


