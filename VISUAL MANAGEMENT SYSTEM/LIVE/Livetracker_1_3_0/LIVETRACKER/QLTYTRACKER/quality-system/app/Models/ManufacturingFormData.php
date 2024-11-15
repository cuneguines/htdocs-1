<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManufacturingFormData extends Model
{
    use HasFactory;
    protected $table = 'QUALITY_PACK.dbo.ManufacturingFormData';
    protected $fillable = [
        'production_drawings',
        'production_drawings_document',
        'bom',
        'bom_document',
        'machine_programming_files',
        'machine_programming_files_document',
        'ndt_documentation',
        'ndt_documentation_document',
        'quality_documents',
        'quality_documents_document',
        'sign_off_manufacturing',
        'comments_manufacturing',
        'process_order_number'
    ];

    
}
