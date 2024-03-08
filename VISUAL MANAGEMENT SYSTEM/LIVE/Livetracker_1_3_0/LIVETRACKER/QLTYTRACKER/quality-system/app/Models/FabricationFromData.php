<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FabricationFromData extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'FitUpVisualCheck',
        'DimensionalCheck',
        'LinkToDrawing',
        'WeldmentQuantity',
        'Status',
        'Quantity',
        'SignOffUser',
        'Comments',
        'ProcessOrder',
        
    ];
    

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'QUALITY_PACK.dbo.FabricationFitUpFormData';

   
}
