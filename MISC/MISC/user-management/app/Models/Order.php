<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    protected $table = 'ordr';

    public static function getTopTenOrders()
    {
        return DB::table('ordr')
            ->select('CardName')
            ->take(10)
            ->get();
    }
}
