<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Engineer_tableData extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'reference_job_master_file',
        'reference_job_master_file_document',
        'concept_design_engineering',
        'design_validation_sign_off',
        'customer_submittal_package',
        'reference_approved_samples',
        'concept_design_document',
        'customer_approval_document',
        'design_validation_document',
        'sample_approval_document',
        'sign_off_engineering',
        'comments_engineering',
        'submission_date',
        'process_order_number',
    ];

    protected $table = 'QUALITY_PACK.dbo.EngineeringFormData';

   
}
