<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialPreparation_tableData extends Model
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
            'sign_off_material_preparation',
            'comments_material_preparation',
            // Add other fields as needed
        ];
    
        protected $table = 'QUALITY_PACK.dbo.MaterialPreparationFormData';
    }
    

