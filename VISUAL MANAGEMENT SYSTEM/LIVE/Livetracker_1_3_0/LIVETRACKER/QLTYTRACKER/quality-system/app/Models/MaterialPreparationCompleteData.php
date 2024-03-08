<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialPreparationCompleteData extends Model
{
    use HasFactory;
    protected $fillable = [
        'process_order_number',
        'material_identification',
        'material_identification_record',
        'material_traceability',
        'cutting',
        'deburring',
        'forming',
        'machining',
        'sign_off_material_complete_preparation',
        'comments_material_preparation',
        'sign_off_engineer',
        'quantity', // Add quantity field
        'status',   // Add status field
        // Add other fields as needed
    ];

    protected $table = 'QUALITY_PACK.dbo.MaterialPreparationFormCompleteData';
}