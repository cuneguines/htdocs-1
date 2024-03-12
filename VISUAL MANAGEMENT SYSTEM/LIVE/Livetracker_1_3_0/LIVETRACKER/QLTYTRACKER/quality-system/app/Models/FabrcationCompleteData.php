<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class FabrcationCompleteData extends Model
{
    use HasFactory;
    protected $fillable = [
        'Id',
        'FitUpVisualCheck',
        'DimensionalCheck',
        'LinkToDrawing',
        'WeldmentQuantity',
        'Status',
        'Quantity',
        'SignOffUser',
        'Comments',
        'ProcessOrder',
        'updated_at',
        'created_at',
        // Add other fields as needed
    ];
    

    protected $table = 'QUALITY_PACK.dbo.FabricationFitUpCompleteData';
}


