
<?php
    include '../../../SQL/connections/conn.php';
    include './SQL_headline_figures.php';

    $getResults = $conn->prepare($sales_per_day_query);
    $getResults->execute();
    $sales_per_day_data = $getResults->fetchAll(PDO::FETCH_BOTH);

    $getResults = $conn->prepare($today_sales_query);
    $getResults->execute();
    $today_sales_data = $getResults->fetchAll(PDO::FETCH_BOTH);

    $getResults = $conn->prepare($yesterday_sales_query);
    $getResults->execute();
    $yesterday_sales_data = $getResults->fetchAll(PDO::FETCH_BOTH);

    $getResults = $conn->prepare($top_customers_query);
    $getResults->execute();
    $top_customers_data = $getResults->fetchAll(PDO::FETCH_BOTH);

    $getResults = $conn->prepare($top_sales_people_query);
    $getResults->execute();
    $top_sales_people_data = $getResults->fetchAll(PDO::FETCH_BOTH);

    $json_data = array();

    foreach($sales_per_day_data as $day)
    {
        array_push($json_data, array($day["Date"], $day["Business Unit"], (int)$day["Sales Value"]));
    }

    $schema  = array(array('name' => 'Date', 'type' => 'date', 'format' => '%d-%m-%y'),array('name' => 'BU', 'type' => 'string'),array('name' => 'Sales Value', 'type' => 'number'));
    
    file_put_contents("CACHED/data_last_updated.json", getdate()[0]);

    file_put_contents("CACHED/data_schema.json", json_encode($schema));
    file_put_contents("CACHED/data.json", json_encode($json_data));

    file_put_contents("CACHED/today_sales.json", json_encode($today_sales_data));
    file_put_contents("CACHED/yesterday_sales.json", json_encode($yesterday_sales_data));
    file_put_contents("CACHED/top_customers.json", json_encode($top_customers_data));
    file_put_contents("CACHED/top_sales_people.json", json_encode($top_sales_people_data));

    header('Location:BASE_sales_menu.php');
?>
