<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class GlobalOwnerNdt extends Model
{
    use HasFactory;

    protected $table = 'QUALITY_PACK.dbo.Planning_Owner_NDT'; // Update to your actual table name if different

    protected $fillable = [
        'Type',
        'owner',
        'ndta',
        'process_order_number'
      
    ];
}