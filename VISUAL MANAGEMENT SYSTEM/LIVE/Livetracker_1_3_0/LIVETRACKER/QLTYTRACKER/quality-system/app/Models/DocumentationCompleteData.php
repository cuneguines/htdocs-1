<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentationCompleteData extends Model
{
    use HasFactory;

    protected $fillable = [
        'process_order_number',
        
      
        'sign_off_documentation',
        'comments_documentation',
        'status',
        'quantity',
        'labelattached',
        // Add other fields as needed
    ];

    protected $table = 'QUALITY_PACK.dbo.DocumentationCompleteData';
}
