<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialPreparationFormData extends Model
{
    use HasFactory;
    protected $table = 'QUALITY_PACK.dbo.MaterialPreparationFormData';

    protected $fillable = [
        'process_order_number',
        'material_identification',
        'material_identification_record',
        'material_traceability',
        'cutting',
        'deburring',
        'forming',
        'machining',
        'sign_off_material_preparation',
        'comments_material_preparation',
        'material_identification_record_file',
        'material_traceability_file',
        // Add other fields here
    ];
}
