<?php
    $line_chart_1_json_data = array();
    $line_chart_2_json_data = array();

    // FIND CURRENT TIME
    $current_time = getdate()[0];

    // INCLUDE DB CONNECTION AND QUERY
    include '../../../PHP LIBS/PHP FUNCTIONS/php_function.php';
    include '../../../PHP LIBS/PHP FUNCTIONS/php_constants.php';
    include '../../../SQL/CONNECTIONS/conn.php';
    include './SQL_management_page.php';
    include '../../TABLES/FINANCE/BY DELIVERED/SQL_filter_by_delivered_finance_table.php';
    include '../../TABLES/FINANCE/BY STATUS/SQL_filter_by_status_finance_table.php';
    require '../../../PHP LIBS/phpspreadsheets/vendor/autoload.php';
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

    // EXECUTE QUERIES
    $finance_table_data = get_sap_data($conn,$finance_table_sql,DEFAULT_DATA);
    $delivered_this_month = get_sap_data($conn,$delivered_this_month_sql,DEFAULT_DATA);
    $delivered_on_time_this_month = get_sap_data($conn,$delivered_on_time_this_month_sql,DEFAULT_DATA);
    $delivered_this_year = get_sap_data($conn,$delivered_this_year_sql,DEFAULT_DATA);
    $delivered_on_time_this_year = get_sap_data($conn,$delivered_on_time_this_year_sql,DEFAULT_DATA);
    $delivered_last_year = get_sap_data($conn,$delivered_last_year_sql,DEFAULT_DATA);
    $delivered_on_time_last_year = get_sap_data($conn,$delivered_on_time_last_year_sql,DEFAULT_DATA);
    
    $confirmed_four_months = get_sap_data($conn,$confirmed_four_months_sql,DEFAULT_DATA);
    $total_four_months =  get_sap_data($conn,$total_four_months_sql,DEFAULT_DATA);
    $confirmed_total =  get_sap_data($conn,$confirmed_this_year_sql,DEFAULT_DATA);
    $total_this_month =  get_sap_data($conn,$total_this_month_sql,DEFAULT_DATA);
    $total_this_year =  get_sap_data($conn,$total_this_year_sql,DEFAULT_DATA);
    $total_last_year =  get_sap_data($conn,$total_last_year_sql,DEFAULT_DATA);
    $status_table_data =  get_sap_data($conn,$status_table_sql,DEFAULT_DATA);
    $delivered_table_data =  get_sap_data($conn,$delivered_table_sql,DEFAULT_DATA);
    $in_stock_this_month_data =  get_sap_data($conn,$in_stock_this_month_sql,DEFAULT_DATA);
    $in_stock_this_year_data =  get_sap_data($conn,$in_stock_this_year_sql,DEFAULT_DATA);
    $in_stock_last_year_data =  get_sap_data($conn,$in_stock_last_year_sql,DEFAULT_DATA);

    // FORMAT HEADLINE FIGURES INTO JSON ARRAY FORMAT
    $headline_figures = array('Del This Y' => $delivered_this_year[0][0],'Del Last Y' => $delivered_last_year[0][0],'Confirmed Four Months' => $confirmed_four_months[0][0], 'Total Four Months' => $total_four_months[0][0], 'Confirmed Total' => $confirmed_total[0][0], 'Total Overall' => $total_this_year[0][0]);
    
    // ARRAYS FOR EACH CATEGORY (LINE CHART)
    $chart_1_category = array();
    $chart_1_pre_production_forecast = array();
    $chart_1_pre_production_potential = array();
    $chart_1_pre_production_confirmed = array();
    $chart_1_live = array();
    $chart_1_total = array();
    $chart_1_delivered = array();
    
    $chart_2_category = array();
    $chart_2_pre_production_forecast = array();
    $chart_2_pre_production_potential = array();
    $chart_2_pre_production_confirmed = array();
    $chart_2_live = array();
    $chart_2_total = array();
    $chart_2_delivered = array();

    // FORMAT JSON ARRAYS FOR CHART
    for($i = 12; $i <= 24 ; $i++)
    {
        // VALUES
        array_push($chart_1_pre_production_forecast, array('value' => $finance_table_data[$i]["Pre Production Forecast"] == null ? 0 : $finance_table_data[$i]["Pre Production Forecast"]));
        array_push($chart_1_pre_production_potential, array('value' => $finance_table_data[$i]["Pre Production Potential"] == null ? 0 :  $finance_table_data[$i]["Pre Production Potential"]));
        array_push($chart_1_pre_production_confirmed, array('value' => $finance_table_data[$i]["Pre Production Confirmed"] == null ? 0 : $finance_table_data[$i]["Pre Production Confirmed"]));
        array_push($chart_1_live, array('value' => $finance_table_data[$i]["Live"] == null ? 0 : $finance_table_data[$i]["Live"]));
        array_push($chart_1_total, array('value' => ($finance_table_data[$i]["Pre Production Forecast"]+$finance_table_data[$i]["Pre Production Potential"]+$finance_table_data[$i]["Pre Production Confirmed"]+$finance_table_data[$i]["Live"]+$finance_table_data[$i]["Delivered"])));
        array_push($chart_1_delivered, array('value' => $finance_table_data[$i]["Delivered"] == null ? 0 : $finance_table_data[$i]["Delivered"]));
        // CATEGORIES
        array_push($chart_1_category, array('label' => $finance_table_data[$i]["Month"]));
    }

    array_push($line_chart_1_json_data, array('seriesname' => 'Pre Production Forecast', "initiallyhidden" => "1", 'data' => $chart_1_pre_production_forecast));
    array_push($line_chart_1_json_data, array('seriesname' => 'Pre Production Potential', "initiallyhidden" => "1", 'data' => $chart_1_pre_production_potential));
    array_push($line_chart_1_json_data, array('seriesname' => 'Pre Production Confirmed', "initiallyhidden" => "1", 'data' => $chart_1_pre_production_confirmed));
    array_push($line_chart_1_json_data, array('seriesname' => 'Live', 'data' => $chart_1_live));
    array_push($line_chart_1_json_data, array('seriesname' => 'Total', 'data' => $chart_1_total));
    array_push($line_chart_1_json_data, array('seriesname' => 'Delivered', "initiallyhidden" => "1", 'data' => $chart_1_delivered));

    
    // FORMAT JSON ARRAYS FOR CHART
    for($i = 0; $i <= 24 ; $i++)
    {
        // VALUES
        array_push($chart_2_pre_production_forecast, array('value' => $finance_table_data[$i]["Pre Production Forecast"] == null ? 0 : $finance_table_data[$i]["Pre Production Forecast"]));
        array_push($chart_2_pre_production_potential, array('value' => $finance_table_data[$i]["Pre Production Potential"] == null ? 0 :  $finance_table_data[$i]["Pre Production Potential"]));
        array_push($chart_2_pre_production_confirmed, array('value' => $finance_table_data[$i]["Pre Production Confirmed"] == null ? 0 : $finance_table_data[$i]["Pre Production Confirmed"]));
        array_push($chart_2_live, array('value' => $finance_table_data[$i]["Live"] == null ? 0 : $finance_table_data[$i]["Live"]));
        array_push($chart_2_total, array('value' => ($finance_table_data[$i]["Pre Production Forecast"]+$finance_table_data[$i]["Pre Production Potential"]+$finance_table_data[$i]["Pre Production Confirmed"]+$finance_table_data[$i]["Live"]+$finance_table_data[$i]["Delivered"]+1)));
        array_push($chart_2_delivered, array('value' => $finance_table_data[$i]["Delivered"] == null ? 0 : $finance_table_data[$i]["Delivered"]));
        // CATEGORIES
        array_push($chart_2_category, array('label' => $finance_table_data[$i]["Month"]));
    }
    // CONCATINATE ARRAYS INTO SINGLE ARRAY
    array_push($line_chart_2_json_data, array('seriesname' => 'Pre Production Forecast', "initiallyhidden" => "1", 'data' => $chart_2_pre_production_forecast));
    array_push($line_chart_2_json_data, array('seriesname' => 'Pre Production Potential', "initiallyhidden" => "1", 'data' => $chart_2_pre_production_potential));
    array_push($line_chart_2_json_data, array('seriesname' => 'Pre Production Confirmed', "initiallyhidden" => "1", 'data' => $chart_2_pre_production_confirmed));
    array_push($line_chart_2_json_data, array('seriesname' => 'Live', "initiallyhidden" => "1", 'data' => $chart_2_live));
    array_push($line_chart_2_json_data, array('seriesname' => 'Total', 'data' => $chart_2_total));
    array_push($line_chart_2_json_data, array('seriesname' => 'Delivered', 'data' => $chart_2_delivered));
    

    // VALUES FOR EACH CATEGORY (PIE CHART)
    $pre_production_forecast_total = 0;
    $pre_production_potential_total = 0;
    $pre_production_confirmed_total = 0;
    $live_total = 0;
    $closed_total = 0;
    $delivered_total = 0;

    // ECODE AND SAVE ALL JSON FORMATTED ARRAYS AS JSON FILES
    file_put_contents("CACHED/data_last_updated.json", $current_time);
    file_put_contents("CACHED/table_data.json", json_encode($finance_table_data, JSON_NUMERIC_CHECK)); 
    file_put_contents("CACHED/headline_figures_data.json", json_encode($headline_figures));

    file_put_contents("CACHED/line_chart_catagories_data.json", json_encode($chart_1_category));
    file_put_contents("CACHED/line_chart_values_data.json", json_encode($line_chart_1_json_data));
    
    file_put_contents("CACHED/line_chart_2_catagories_data.json", json_encode($chart_2_category));
    file_put_contents("CACHED/line_chart_2_values_data.json", json_encode($line_chart_2_json_data));

    file_put_contents("CACHED/ontime_delivery_this_month_kpi.json", json_encode(array('Delivered This Month' => $delivered_this_month[0][0], 'Delivered On Time This Month' => $delivered_on_time_this_month[0][0]), JSON_NUMERIC_CHECK));
    file_put_contents("CACHED/ontime_delivery_this_year_kpi.json", json_encode(array('Delivered This Year' => $delivered_this_year[0][0], 'Delivered On Time This Year' => $delivered_on_time_this_year[0][0]), JSON_NUMERIC_CHECK));
    file_put_contents("CACHED/ontime_delivery_last_year_kpi.json", json_encode(array('Delivered Last Year' => $delivered_last_year[0][0], 'Delivered On Time Last Year' => $delivered_on_time_last_year[0][0]), JSON_NUMERIC_CHECK));

    file_put_contents("CACHED/delivered_this_month_kpi.json", json_encode(array('In Stock This Month' => $in_stock_this_month_data[0][0],'Delivered This Month' => $delivered_this_month[0][0],'Total This Month' => $total_this_month[0][0]), JSON_NUMERIC_CHECK));
    file_put_contents("CACHED/delivered_this_year_kpi.json", json_encode(array('In Stock This Year' => $in_stock_this_year_data[0][0],'Delivered This Year' => $delivered_this_year[0][0], 'Total This Year' => $total_this_year[0][0]), JSON_NUMERIC_CHECK));
    file_put_contents("CACHED/delivered_last_year_kpi.json", json_encode(array('In Stock Last Year' => $in_stock_last_year_data[0][0],'Delivered Last Year' => $delivered_last_year[0][0], 'Total Last Year' => $total_last_year[0][0]), JSON_NUMERIC_CHECK));

    // STATUS TABLE DATA
    file_put_contents(__DIR__."..\..\..\TABLES\FINANCE\BY STATUS\CACHED\status_table_data.json", json_encode($status_table_data));
    file_put_contents(__DIR__."..\..\..\TABLES\FINANCE\BY STATUS\CACHED\data_last_updated.json", $current_time);

    // DELIVERED TABLE DATA
    file_put_contents(__DIR__."..\..\..\TABLES\FINANCE\BY DELIVERED\CACHED\delivered_table_data.json", json_encode($delivered_table_data));
    file_put_contents(__DIR__."..\..\..\TABLES\FINANCE\BY DELIVERED\CACHED\data_last_updated.json", $current_time);

    $top_customers = array();
    $top_bp_d_customers = array();
    $top_bp_prbp_customers = array();
    $top_bp_prksp_customers = array();
    $top_ec_in_customers = array();
    $top_ec_mb_customers = array();
    $top_st_customers = array();

    $cumulative_buff = array(0,0,0,0);
    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
    $spreadsheet = $reader->load('C://VMS_MASTER_DATA/DATA/ytd_data.xlsx');
    for($i = 4 ; $i < 14 ; $i++)
    {
        array_push($top_customers,
            array(  'customer name' => $spreadsheet->getSheetByName('Customers')->GetCell('A'.$i)->getValue(),
                    'sales value' => round($spreadsheet->getSheetByName('Customers')->GetCell('B'.$i)->getValue()/1000000, 2),
                    'sales margin' => round($spreadsheet->getSheetByName('Customers')->GetCell('C'.$i)->getValue()/$spreadsheet->getSheetByName('Customers')->GetCell('B'.$i)->getValue()*100,0),
                    'percentage of total' => round($spreadsheet->getSheetByName('Customers')->GetCell('D'.$i)->getValue(),2)*100,
                    'percentage of total cum' => round($cumulative_buff[0] + $spreadsheet->getSheetByName('Customers')->GetCell('D'.$i)->getValue(),2)*100));
                    $cumulative_buff[0] += $spreadsheet->getSheetByName('Customers')->GetCell('D'.$i)->getValue();

        array_push($top_bp_d_customers,
            array(  'customer name' => $spreadsheet->getSheetByName('Business Units')->GetCell('A'.$i)->getValue(),
                    'sales value' => round($spreadsheet->getSheetByName('Business Units')->GetCell('B'.$i)->getValue()/1000000, 2),
                    'sales margin' => round($spreadsheet->getSheetByName('Business Units')->GetCell('C'.$i)->getValue()/$spreadsheet->getSheetByName('Business Units')->GetCell('B'.$i)->getValue()*100,0),
                    'percentage of total' => round($spreadsheet->getSheetByName('Business Units')->GetCell('D'.$i)->getValue(),2)*100,
                    'percentage of total cum' => round($cumulative_buff[1] + $spreadsheet->getSheetByName('Business Units')->GetCell('D'.$i)->getValue(),2)*100));
                    $cumulative_buff[1] += $spreadsheet->getSheetByName('Business Units')->GetCell('D'.$i)->getValue();

        array_push($top_bp_prbp_customers,
            array(  'customer name' => $spreadsheet->getSheetByName('Business Units')->GetCell('F'.$i)->getValue(),
                    'sales value' => round($spreadsheet->getSheetByName('Business Units')->GetCell('G'.$i)->getValue()/1000000, 2),
                    'sales margin' => round($spreadsheet->getSheetByName('Business Units')->GetCell('H'.$i)->getValue()/$spreadsheet->getSheetByName('Business Units')->GetCell('G'.$i)->getValue()*100,0),
                    'percentage of total' => round($spreadsheet->getSheetByName('Business Units')->GetCell('I'.$i)->getValue(),2)*100,
                    'percentage of total cum' => round($cumulative_buff[2] + $spreadsheet->getSheetByName('Business Units')->GetCell('I'.$i)->getValue(),2)*100));
                    $cumulative_buff[2] += $spreadsheet->getSheetByName('Business Units')->GetCell('I'.$i)->getValue();

        array_push($top_bp_prksp_customers,
            array(  'customer name' => $spreadsheet->getSheetByName('Business Units')->GetCell('K'.$i)->getValue(),
                    'sales value' => round($spreadsheet->getSheetByName('Business Units')->GetCell('L'.$i)->getValue()/1000000, 2),
                    'sales margin' => round($spreadsheet->getSheetByName('Business Units')->GetCell('M'.$i)->getValue()/$spreadsheet->getSheetByName('Business Units')->GetCell('L'.$i)->getValue()*100,0),
                    'percentage of total' => round($spreadsheet->getSheetByName('Business Units')->GetCell('N'.$i)->getValue(),2)*100,
                    'percentage of total cum' => round($cumulative_buff[3] + $spreadsheet->getSheetByName('Business Units')->GetCell('N'.$i)->getValue(),2)*100));
                    $cumulative_buff[3] += $spreadsheet->getSheetByName('Business Units')->GetCell('N'.$i)->getValue();
        
        array_push($top_ec_in_customers,
            array(  'customer name' => $spreadsheet->getSheetByName('Business Units')->GetCell('P'.$i)->getValue(),
                    'sales value' => round($spreadsheet->getSheetByName('Business Units')->GetCell('Q'.$i)->getValue()/1000000, 2),
                    'sales margin' => round($spreadsheet->getSheetByName('Business Units')->GetCell('R'.$i)->getValue()/$spreadsheet->getSheetByName('Business Units')->GetCell('L'.$i)->getValue()*100,0),
                    'percentage of total' => round($spreadsheet->getSheetByName('Business Units')->GetCell('S'.$i)->getValue(),2)*100,
                    'percentage of total cum' => round($cumulative_buff[4] + $spreadsheet->getSheetByName('Business Units')->GetCell('S'.$i)->getValue(),2)*100));
                    $cumulative_buff[4] += $spreadsheet->getSheetByName('Business Units')->GetCell('S'.$i)->getValue();
    
        array_push($top_ec_mb_customers,
            array(  'customer name' => $spreadsheet->getSheetByName('Business Units')->GetCell('U'.$i)->getValue(),
                    'sales value' => round($spreadsheet->getSheetByName('Business Units')->GetCell('V'.$i)->getValue()/1000000, 2),
                    'sales margin' => round($spreadsheet->getSheetByName('Business Units')->GetCell('W'.$i)->getValue()/$spreadsheet->getSheetByName('Business Units')->GetCell('L'.$i)->getValue()*100,0),
                    'percentage of total' => round($spreadsheet->getSheetByName('Business Units')->GetCell('X'.$i)->getValue(),2)*100,
                    'percentage of total cum' => round($cumulative_buff[5] + $spreadsheet->getSheetByName('Business Units')->GetCell('X'.$i)->getValue(),2)*100));
                    $cumulative_buff[5] += $spreadsheet->getSheetByName('Business Units')->GetCell('X'.$i)->getValue();

        array_push($top_st_customers,
            array(  'customer name' => $spreadsheet->getSheetByName('Business Units')->GetCell('Z'.$i)->getValue(),
                    'sales value' => round($spreadsheet->getSheetByName('Business Units')->GetCell('AA'.$i)->getValue()/1000000, 2),
                    'sales margin' => round($spreadsheet->getSheetByName('Business Units')->GetCell('AB'.$i)->getValue()/$spreadsheet->getSheetByName('Business Units')->GetCell('L'.$i)->getValue()*100,0),
                    'percentage of total' => round($spreadsheet->getSheetByName('Business Units')->GetCell('AC'.$i)->getValue(),2)*100,
                    'percentage of total cum' => round($cumulative_buff[6] + $spreadsheet->getSheetByName('Business Units')->GetCell('AC'.$i)->getValue(),2)*100));
                    $cumulative_buff[6] += $spreadsheet->getSheetByName('Business Units')->GetCell('AC'.$i)->getValue();
    }

    file_put_contents("CACHED/top_customers.json", json_encode($top_customers));
    file_put_contents("CACHED/top_bp_d_customers.json", json_encode($top_bp_d_customers));
    file_put_contents("CACHED/top_bp_prbp_customers.json", json_encode($top_bp_prbp_customers));
    file_put_contents("CACHED/top_bp_prksp_customers.json", json_encode($top_bp_prksp_customers));
    file_put_contents("CACHED/top_ec_in_customers.json", json_encode($top_ec_in_customers));
    file_put_contents("CACHED/top_ec_mb_customers.json", json_encode($top_ec_mb_customers));
    file_put_contents("CACHED/top_st_customers.json", json_encode($top_st_customers));

    header('Location:BASE_management_menu.php');
?>