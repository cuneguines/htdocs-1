<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinishingCompleteData extends Model
{
    use HasFactory;

    protected $fillable = [
        'process_order_number',
        'pickle_passivate_test',
        'pickle_passivate_document_ref',
        'select_kent_finish_test',
        'select_kent_finish_document_ref',
        'sign_off_finishing',
        'comments_finishing',
        'submission_date',
        'status',
        'quantity',
        'created_at',
        'updated_at',
    ];
    protected $table = 'QUALITY_PACK.dbo.FinishingCompleteData';
}

