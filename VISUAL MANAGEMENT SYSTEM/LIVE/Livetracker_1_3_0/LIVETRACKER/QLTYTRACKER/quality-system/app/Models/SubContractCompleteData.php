<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubContractCompleteData extends Model
{
    use HasFactory;

  




    protected $table = 'QUALITY_PACK.dbo.subcontractCompleteData';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'process_order_number',
        'sub_contract_action',
        'sign_off_sub_contract',
        'comments_sub_contract',
        'submission_date',
        'status',
        'quantity',
    ];
}




