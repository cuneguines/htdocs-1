<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubContractFormData extends Model
{
    use HasFactory;

 


    protected $table = 'QUALITY_PACK.dbo.subcontractFormData';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sub_contract_action',
        'sign_off_sub_contract',
        'comments_sub_contract',
        'submission_date',
        'process_order_number',
        'sub_contract_file',
    ];
}


