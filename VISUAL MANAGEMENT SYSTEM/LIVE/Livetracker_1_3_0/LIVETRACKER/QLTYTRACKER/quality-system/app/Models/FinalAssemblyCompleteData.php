<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinalAssemblyCompleteData extends Model
{
    use HasFactory;

    protected $fillable = [
        'Id',
        'process_order_number',
        'walk_down_inspection',
        'identification',
        'final_assembly_file_1',
        'final_assembly_file_2',
        'final_assembly_file_3',
        'status',
        'quantity',
        'sign_off_final_assembly',
        'comments_final_assembly',
        'created_at',
        'updated_at',
        // Add other fields as needed
    ];

    protected $table = 'QUALITY_PACK.dbo.FinalAssemblyCompleteData';
}