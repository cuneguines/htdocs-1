<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackingTransportCompleteData extends Model
{
    use HasFactory;

    protected $fillable = [
        'process_order_number',
     
     
        'sign_off_documentation',
        'comments_documentation',
        'status',
        'quantity',
       
        'secure_packing',
        'photos_attached',
        // Add other fields as needed
    ];

    protected $table = 'QUALITY_PACK.dbo.PackingTransportCompleteData';
}
