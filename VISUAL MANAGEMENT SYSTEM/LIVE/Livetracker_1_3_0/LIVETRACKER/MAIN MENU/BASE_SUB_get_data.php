<?php


    include '../../SQL CONNECTIONS/conn.php';
    include "../../PHP LIBS/PHP SETTINGS/php_settings.php";
    include "../PRE PRODUCTION/EXCEPTIONS/pre production exceptions/SQL_pre_production_exceptions.php";
    include "../PRODUCTION/EXCEPTIONS/production exceptions/SQL_production_exception.php";
    include "../SALES/EXCEPTIONS/sales exceptions/SQL_sales_exceptions.php";
    include "./dashboard_menu_values.php";  

    $getResults = $conn->prepare($pre_production_exceptions);
	$getResults->execute();
    $exceptions_values = $getResults->fetchAll(PDO::FETCH_BOTH);
    $pp_exceptions = 0;
    foreach($exceptions_values as $row)
    {
        // DETERMIE THE COLOR FOR EACH ROW
        // STAGE 1.DRAWING APPROVED = GREEN
        if($row["Weeks Overdue"] > 0)
        {
            $pp_exceptions++;
        }
    }
 
    $getResults = $conn->prepare($production_exceptions);
	$getResults->execute();
    $exceptions_values = $getResults->fetchAll(PDO::FETCH_BOTH);
    $p_exceptions = 0;
    foreach($exceptions_values as $row)
    {
        // DETERMIE THE COLOR FOR EACH ROW
        // STAGE 1.DRAWING APPROVED = GREEN
        if($row["Weeks Overdue_2"] > 0 && $row["Weeks Overdue_2"] != "ON TIME")
        {
            $p_exceptions++;
        }
    }

    $getResults = $conn->prepare($sales_exceptions);
	$getResults->execute();
    $exceptions_values = $getResults->fetchAll(PDO::FETCH_BOTH);
    $s_exceptions = 0;
    foreach($exceptions_values as $row)
    {
        // DETERMIE THE COLOR FOR EACH ROW
        // STAGE 1.DRAWING APPROVED = GREEN
        if($row["Weeks Overdue_2"] > 0)
        {
            $s_exceptions++;
        }
    }
    
    $getResults = $conn->prepare($closed_orders_year_q);
    $getResults->execute();
    $closed_orders_year_d = $getResults->fetchAll(PDO::FETCH_BOTH);
    $getResults = $conn->prepare($closed_orders_month_q);
    $getResults->execute();
    $closed_orders_month_d = $getResults->fetchAll(PDO::FETCH_BOTH);
    $getResults = $conn->prepare($closed_orders_week_q);
    $getResults->execute();
    $closed_orders_week_d = $getResults->fetchAll(PDO::FETCH_BOTH);

    $getResults = $conn->prepare($closed_percentage_year_q);
    $getResults->execute();
    $closed_percentage_year_d = $getResults->fetchAll(PDO::FETCH_BOTH);
    $getResults = $conn->prepare($closed_percentage_month_q);
    $getResults->execute();
    $closed_percentage_month_d = $getResults->fetchAll(PDO::FETCH_BOTH);
    $getResults = $conn->prepare($closed_percentage_week_q);
    $getResults->execute();
    $closed_percentage_week_d = $getResults->fetchAll(PDO::FETCH_BOTH);

    $getResults = $conn->prepare($comp_po_w_q);
    $getResults->execute();
    $comp_po_week_d = $getResults->fetchAll(PDO::FETCH_BOTH);
    $getResults = $conn->prepare($comp_po_m_q);
    $getResults->execute();
    $comp_po_month_d = $getResults->fetchAll(PDO::FETCH_BOTH);
    $getResults = $conn->prepare($comp_po_y_q);
    //$getResults->execute();
    $comp_po_year_d = $getResults->fetchAll(PDO::FETCH_BOTH);

    $getResults = $conn->prepare($p_hours_w_q);
    $getResults->execute();
    $p_hours_week_d = $getResults->fetchAll(PDO::FETCH_BOTH);
    $getResults = $conn->prepare($p_hours_m_q);
    $getResults->execute();
    $p_hours_month_d = $getResults->fetchAll(PDO::FETCH_BOTH);
    $getResults = $conn->prepare($p_hours_y_q);
    $getResults->execute();
    $p_hours_year_d = $getResults->fetchAll(PDO::FETCH_BOTH);






    $getResults = $conn->prepare($lo_hrs);
    $getResults->execute();
    $live_orders_hours = $getResults->fetchAll(PDO::FETCH_BOTH);

    $getResults = $conn->prepare($lo_val);
    $getResults->execute();
    $live_orders_val = $getResults->fetchAll(PDO::FETCH_BOTH);

    $getResults = $conn->prepare($pp_con);
    $getResults->execute();
    $pre_prod_confirmed = $getResults->fetchAll(PDO::FETCH_BOTH);

    $getResults = $conn->prepare($pp_pot);
    $getResults->execute();
    $pre_prod_potential = $getResults->fetchAll(PDO::FETCH_BOTH);

    $getResults = $conn->prepare($pp_for);
    $getResults->execute();
    $pre_prod_forecast = $getResults->fetchAll(PDO::FETCH_BOTH);

    $getResults = $conn->prepare($five_week_average);
    $getResults->execute();
    $five_week_average_prod = $getResults->fetchAll(PDO::FETCH_BOTH);

    $getResults = $conn->prepare($full_schedule);
	$getResults->execute();
    $full_schedule_count = $getResults->fetchAll(PDO::FETCH_BOTH);

    file_put_contents("CACHED/pre_production_exceptions.json", $pp_exceptions);
    file_put_contents("CACHED/production_exceptions.json", $p_exceptions);
    file_put_contents("CACHED/sales_exceptions.json", $s_exceptions);

    file_put_contents("CACHED/closed_orders_year_data.json", json_encode($closed_orders_year_d));
    file_put_contents("CACHED/closed_orders_month_data.json", json_encode($closed_orders_month_d));
    file_put_contents("CACHED/closed_orders_week_data.json", json_encode($closed_orders_week_d));

    file_put_contents("CACHED/closed_percentage_year_data.json", json_encode($closed_percentage_year_d));
    file_put_contents("CACHED/closed_percentage_month_data.json", json_encode($closed_percentage_month_d));
    file_put_contents("CACHED/closed_percentage_week_data.json", json_encode($closed_percentage_week_d));

    file_put_contents("CACHED/complete_process_orders_year_data.json", json_encode($comp_po_year_d));
    file_put_contents("CACHED/complete_process_orders_month_data.json", json_encode($comp_po_month_d));
    file_put_contents("CACHED/complete_process_orders_week_data.json", json_encode($comp_po_week_d));

    file_put_contents("CACHED/process_orders_hours_year_data.json", json_encode($p_hours_year_d));
    file_put_contents("CACHED/process_orders_hours_month_data.json", json_encode($p_hours_month_d));
    file_put_contents("CACHED/process_orders_hours_week_data.json", json_encode($p_hours_week_d));

    file_put_contents("CACHED/live_orders_hours.json", json_encode($live_orders_hours));
    file_put_contents("CACHED/live_orders_value.json", json_encode($live_orders_val));
    file_put_contents("CACHED/pre_production_confirmed.json", json_encode($pre_prod_confirmed));
    file_put_contents("CACHED/pre_production_potential.json", json_encode($pre_prod_potential));
    file_put_contents("CACHED/pre_production_forecast.json", json_encode($pre_prod_forecast));
    file_put_contents("CACHED/process_orders_five_week.json", json_encode($five_week_average_prod));

    file_put_contents("CACHED/full_schedule_count.json", json_encode($full_schedule_count));
    file_put_contents("CACHED/data_last_updated.json", getdate()[0]);

    header('Location:dashboard_menu.php');

?>