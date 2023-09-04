<?php
use App\Models\Order;

$topTenOrders = Order::getTopTenOrders();
?>
// foreach ($topTenOrders as $order) {
//     echo $order->CardName;
// }
<!DOCTYPE html>
<html>
<head>
    <!-- Head section content goes here -->
</head>
<body>
    <div id="background">
        <div id="content">
            <div class="table_title green">
                <h1>PROCESS ORDER OPENED</h1>
            </div>
            <div id="pages_table_container" >
                <table id="intel_pedestal_production" >
                    <thead>
                        <tr class="dark_grey blue btext small head">
                            <th width="33.3%">Customer</th>
                            <th width="33.3%">CardCode</th>
                            <th width="33.%">Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($topTenOrders as $row)
                            <tr>

                                <td>{{$row->CardName}}</td>
                                <td>{{$row->CardCode}}</td>
                                <td>{{$row->Address}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Rest of the content goes here -->
        </div>
    </div>
    <!-- JavaScript scripts and chart code goes here -->
</body>
</html>
