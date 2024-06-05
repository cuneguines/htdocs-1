<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QualityFormData extends Model
{
    use HasFactory;

    protected $table = 'QUALITY_PACK.dbo.QualityFormData'; // Adjust the table name if needed

    protected $fillable = [
        'walk_down_visual_inspection',
        'comments_quality',
        'sign_off_quality',
        'process_order_number',
        'uiid',
        'uploadimages',
        
    ];
}
