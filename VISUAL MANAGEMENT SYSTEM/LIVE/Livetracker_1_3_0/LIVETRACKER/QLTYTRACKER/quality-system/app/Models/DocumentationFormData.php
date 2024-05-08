<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentationFormData extends Model

{
    use HasFactory;

    protected $table = 'QUALITY_PACK.dbo.DocumentationFormData'; // Adjust the table name if needed

    protected $fillable = [
        'process_order_number',
        'engineer',
        'technical_file',
        'client_handover_documentation',
        'created_at',
        'updated_at',
        'technical_file_check',
        'client_handover_check',
    ];
}


