<!DOCTYPE html>
<html>
<head>
  <!-- INITIALIZATION AND META STUFF -->
  <title>Engineer Hours</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- EXTERNAL JAVASCRIPT -->
  <script type="text/javascript" src="../../VISUAL MANAGEMENT SYSTEM/LIVE/Livetracker_1_3_0/JS LIBS/THIRD PARTY/jquery-3.4.1.js"></script>
  <script type="text/javascript" src="../../VISUAL MANAGEMENT SYSTEM/LIVE/Livetracker_1_3_0/JS LIBS/THIRD PARTY/jquery.tablesorter.js"></script>
  <script type="text/javascript" src="../../VISUAL MANAGEMENT SYSTEM/LIVE/Livetracker_1_3_0/JS LIBS/THIRD PARTY/jquery.tablesorter.widgets.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <!-- LOCAL JAVASCRIPT -->
  <script type="text/javascript" src="../../VISUAL MANAGEMENT SYSTEM/LIVE/Livetracker_1_3_0/JS LIBS/LOCAL/JS_comments.js"></script>
  <script type="text/javascript" src="./filter.js"></script>
  <script type="text/javascript" src="../../VISUAL MANAGEMENT SYSTEM/LIVE/Livetracker_1_3_0/JS LIBS/LOCAL/JS_search_table.js"></script>
  <script type="text/javascript" src="./JS_condition_splits.js"></script>
  <script type="text/javascript" src="./JS_table_to_excel.js"></script>

  <!-- STYLING -->
  <link rel="stylesheet" href="../../VISUAL MANAGEMENT SYSTEM/LIVE/Livetracker_1_3_0/CSS/LT_STYLE.css">
  <link rel="stylesheet" href="../../VISUAL MANAGEMENT SYSTEM/LIVE/Livetracker_1_3_0/css/theme.blackice.min.css">
  <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>

  <!-- PHP INITIALIZATION -->
  <?php //include '../VISUAL MANAGEMENT SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/PHP LIBS/PHP FUNCTIONS/php_functions.php'; ?>
  <?php include "../../VISUAL MANAGEMENT SYSTEM/LIVE/Livetracker_1_3_0/PHP LIBS/PHP FUNCTIONS/php_functions.php"?>
  <?php include '../../VISUAL MANAGEMENT SYSTEM/LIVE/Livetracker_1_3_0/SQL CONNECTIONS/conn.php'; ?>
  <?php include './SQL_Engineer_hours.php'; ?>
  <?php $results = get_sap_data($conn, $engr, DEFAULT_DATA); ?>


  <!-- TABLESORTER INITIALIZATION -->
  <script>
    $(function(){
      $("table.sortable").tablesorter({
        "theme": "blackice",
        "dateFormat": "ddmmyyyy",
        "headers": {
          1: {sorter: true},
          2: {sorter:true},
          3: {sorter: true},
          4: {sorter: true}
          
        }
      });
    });
  </script>

  <style>
    .table_container2#pages_table_container {
    top: 2%;
    height: 50%;
}
.table_container2 {
    position: relative;
    width: 100%;
    overflow-y: scroll;
}


  th, td {
    padding: 10px;
    border: 1px solid #ccc;
    
    box-shadow: 1px 1px 3px rgba(0, 0, 0, 0.3);
  }
  tr:nth-child(2n) {
    background-color: #f2f2f2;
  }

  tr:nth-child(2n+2) {
    background-color: #ffeb3b1c;
  }
.dark_grey{
    background-color: grey;
}
    </style>
</head>

<body>
  <div id="background" style="float: left; width: 100%;">
    <div id="content">
      <div class="table_title green"style="background-color:#03a9f4;box-shadow: -3px 3px 6px #03A9F4, 0 1px 4px #03A9F4;">
        <h1 >ENGINEER HOUR ANALYSIS</h1>
      </div>
      <div id="pages_table_container" class="table_container" style="overflow-y: scroll;box-shadow: -3px 3px 6px #03A9F4, 0 1px 4px #03A9F4;">
        <table id="Engineers_table"style="background-color: white; padding: 3%" id="intel_pedestal_production" class="filterable sortable searchable">
          <thead>
            <tr style="font-size: larger;style=background-color:#f2f2f2" class="dark_grey blue btext small head">
              <th width="12.5%">Sales_Order</th>
              <th width="12.5%">Customer</th>
              <th width="12.5%">Project Name</th>
              <th width="12.5%">Engineer_name</th>
              <th width="12.5%">Engineer_hrs</th>
              <th width="12.5%">Date</th>
              <th width="12.5%">Year</th>
              <th width="12.5%">WeekNumber</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($results as $row) : ?>
              <?php $status = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $row["Engineer_name"])); ?>
              <?php //$fabricator = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $row["Fabricator"])); ?>
              <tr style="padding: 3%" class="btext <?=$rowcolor?>" status="<?=$status?>" fabricator="<?=$fabricator?>" ntk="<?=$ntk?>" style="height: 30px;">
                <td><?=$row["Sales_Order"]?></td>
                <td><?= $row["CardName"] ? $row["CardName"] : "null" ?></td>
                <td><?= $row["Project Name"] ? $row["Project Name"] : "null" ?></td>
                <td ><?=$row["Engineer_name"]?></td>
                <td><?=$row["Engineer_hrs"]?></td>
                <td><?=$row["Date"]?></td>
                <td><?=$row["Year"]?></td>
                <td><?=$row["WeekNumber"]?></td>

              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <div id="table_pages_footer" class="footer" >
        <div id="top">
          <div id="filter_container">
            <div id="filters" class="red fill rounded" style="background-color: #8bc34a">
              <div class="filter">
                <div class="text">
                  <button style="background-color: #8bc34a" class="fill red medium wtext">Engineer</button>
                </div>
                <div class="content">
                  <select id="select_status" class="selector fill medium">
                    <option value="All" selected>All</option>
                    <?php generate_filter_options($results, "Engineer_name"); ?>
                  </select>
                </div>
              </div>
              <div class="filter">
                <div class="text">
                  <button style="background-color: #8bc34a" class="fill red medium wtext">Search Table</button>
                </div>
                <div class="content">
                  <input class="medium" id="employee" type="text">
                </div>
              </div>
            </div>
          </div>
        </div>
        <div id="bottom">
          <div id="button_container">
            <button class="grouping_page_corner_buttons fill medium light_blue wtext rounded">UNUSED <?php //round(($total_executed/$total_planned)*100,2);?></button>
          </div>
          <div id="button_container_wide">
            <button onclick="location.href='../../VISUAL MANAGEMENT SYSTEM/LIVE/Livetracker_1_3_0/'" class="grouping_page_corner_buttons fill medium purple wtext rounded">MAIN MENU</button>
          </div>
          <div id="button_container">
            <button onclick="export_to_excel('Engineers_table')" class="grouping_page_corner_buttons fill medium green wtext rounded">EXPORT</button>
          </div>
        </div>
      </div>
    </div>
  </div>

 
  


</body>
</html>
