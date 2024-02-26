<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LineItem extends Model  // Extend Eloquent Model
{
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'StepDesc','PrOrder','Quantity'
    ];

    protected $table = 'iis_epc_pro_orderl';

    public function orders()
    {
        return $this->belongsTo(Orders::class, 'PrOrder');
    }
}
