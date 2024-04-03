<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class FinalAssemblyFormData extends Model
{
    use HasFactory;

    protected $fillable = [
        'process_order_number',
        'walk_down_inspection',
        'identification',
        'sign_off_final_assembly',
        'comments_final_assembly',
        'submission_date',
        'final_assembly_file_1',
        'final_assembly_file_2',
        'final_assembly_file_3',
    ];
// Assuming your table is named 'images'
protected $table = 'QUALITY_PACK.dbo.FinalAssemblyFormData';
}


