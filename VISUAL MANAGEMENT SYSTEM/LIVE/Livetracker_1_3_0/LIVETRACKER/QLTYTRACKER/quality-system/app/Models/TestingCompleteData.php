<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestingCompleteData extends Model
{
    use HasFactory;
    protected $fillable = [
        'process_order_number',
        'dye_pen_test',
        'dye_pen_document_ref',
        'hydrostatic_test',
        'hydrostatic_test_document_ref',
        'pneumatic_test',
        'pneumatic_test_document_ref',
        'fat_protocol',
        'fat_protocol_document_ref',
        'testing_document_file_name',
        'sign_off_testing',
        'comments_testing',
        'submission_date',
        'status',
        'quantity',
    ];
    protected $table = 'QUALITY_PACK.dbo.TestingCompleteData';
}
