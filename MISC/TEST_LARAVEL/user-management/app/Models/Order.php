<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
# use Illuminate\Support\Facades\DB;

class Order extends Model
{
    protected $table = 'ordr';

    public static function getTopTenOrders()
    {
        return DB::table('ordr')
            ->select('CardName','CardCode','Address')
            ->take(14)
            ->get();
    }
}
