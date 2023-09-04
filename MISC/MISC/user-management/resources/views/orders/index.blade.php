<?php
use App\Models\Order;

$topTenOrders = Order::getTopTenOrders();

foreach ($topTenOrders as $order) {
    echo $order->CardName;
}
