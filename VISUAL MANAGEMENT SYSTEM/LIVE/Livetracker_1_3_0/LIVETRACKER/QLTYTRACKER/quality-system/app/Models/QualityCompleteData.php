<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QualityCompleteData extends Model
{
    use HasFactory;

    protected $table = 'QUALITY_PACK.dbo.QualityCompleteData'; // Adjust the table name if needed

    protected $fillable = [
        'uuid',
        'walk_down_visual_inspection',
        'comments_quality',
        'sign_off_quality',
        'submission_date',
        'process_order_number',
        'quality_images',
    ];
}
