<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackingTransportFormData extends Model
{
    use HasFactory;

    protected $table = 'QUALITY_PACK.dbo.PackingTransportFormData'; // Adjust the table name if needed

    protected $fillable = [
        'process_order_number',
        'engineer',
        'technical_file',
        'secure_packing',
        'client_handover_documentation',
        'created_at',
        'updated_at',
    ];
}
