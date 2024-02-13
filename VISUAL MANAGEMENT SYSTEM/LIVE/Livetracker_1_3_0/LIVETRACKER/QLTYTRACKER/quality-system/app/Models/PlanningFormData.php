<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanningFormData extends Model
{
    use HasFactory;
    protected $table = 'QUALITY_PACK.dbo.PlanningFormData'; // Adjust the table name if needed

    protected $fillable = [


      
        'purchase_order_received',
        'purchase_order_document' ,
        'project_schedule_agreed' ,
        'project_schedule_document' ,
        'quotation' ,
       'quotation_document',
        'verify_customer_expectations' ,
        'user_requirement_specifications_document' ,
        'project_risk_category_assessment ',
        'pre_engineering_check_document',
        'sign_off_planning',
        'comments_planning' ,
     
        'process_order_number',
        
        
        
    ];
}

