<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestingFormData extends Model
{
    use HasFactory;
    
        use HasFactory;
    
        /**
         * The table associated with the model.
         *
         * @var string
         */
        protected $table = 'QUALITY_PACK.dbo.TestingFormDatas';
    
        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = [
            'dye_pen_document_ref',
            'hydrostatic_test_document_ref',
            'pneumatic_test_document_ref',
            'fat_protocol_document_ref',
            'sign_off_testing',
            'comments_testing',
            'submission_date',
            'process_order_number',
            'dye_pen_test',
            'hydrostatic_test',
            'pneumatic_test',
            'fat_protocol',
            'testing_document_file_name', // Assuming this is the field for the uploaded file name
            'created_at',
            'updated_at',
        ];
    }
    


