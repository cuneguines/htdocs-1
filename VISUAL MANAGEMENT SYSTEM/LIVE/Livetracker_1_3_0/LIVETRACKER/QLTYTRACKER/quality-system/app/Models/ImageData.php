<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageData extends Model
{
    use HasFactory;
    protected $fillable = [
        'process_order_id',
        'filename',
        'batch_number',
    ];

    // Assuming your table is named 'images'
    protected $table = 'QUALITY_PACK.dbo.ImageData';

}
