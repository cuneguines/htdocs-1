<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinishingFormData extends Model
{
    use HasFactory;

    protected $table = 'QUALITY_PACK.dbo.FinishingFormData'; // Adjust the table name if needed

    protected $fillable = [
        'process_order_number',
        'pickle_passivate_test',
        'pickle_passivate_document_ref',
        'pickle_passivate_document_file',
        'select_kent_finish_test',
        'select_kent_finish_document_ref',
        'select_kent_finish_document_file',
        'sign_off_finishing',
        'comments_finishing',
        'submission_date',
        'created_at',
        'updated_at',
    ];
}
