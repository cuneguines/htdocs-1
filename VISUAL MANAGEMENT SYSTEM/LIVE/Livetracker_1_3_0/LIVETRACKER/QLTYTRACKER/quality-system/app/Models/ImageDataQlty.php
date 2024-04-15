<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageDataQlty extends Model
{
    use HasFactory;
    use HasFactory;
    protected $fillable = [
        'process_order_id',
        'filename',
        'batch_number',
        'created_at',
        'updated_at',
    ];

    // Assuming your table is named 'images'
    protected $table = 'QUALITY_PACK.dbo.imageData_Qlty';
}
