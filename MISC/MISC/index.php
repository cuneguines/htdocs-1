<!DOCTYPE html>
<html>
<head>
  <!-- INITIALIZATION AND META STUFF -->
  <title>Quality KPI</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- STYLING -->
  <link rel="stylesheet" href="../VISUAL MANAGEMENT SYSTEM/LIVE/Livetracker_1_3_0/CSS/LT_STYLE.css">
  <link rel="stylesheet" href="../VISUAL MANAGEMENT SYSTEM/LIVE/Livetracker_1_3_0/css/theme.blackice.min.css">
  <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>


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
    background-color: #2196f324;
  }
.dark_grey{
    background-color: grey;
}
    </style>
</head>

<body>
  <div id="background" style="float: left; width: 50%;">
    <div id="content">
      <div class="table_title green"style="box-shadow: -3px 3px 6px #03A9F4, 0 1px 4px #03A9F4;">
        <h1>PROCESS ORDER OPENED</h1>
      </div>
      <div id="pages_table_container" class="table_container" style="overflow-y: scroll;box-shadow: -3px 3px 6px #03A9F4, 0 1px 4px #03A9F4;">
        <table style="background-color: white; padding: 3%" id="intel_pedestal_production" class="filterable sortable searchable">
          <thead>
            <tr style="font-size: larger" class="dark_grey blue btext small head">
              <th width="33.3%">Year</th>
              <th width="33.3%">Month</th>
              <th width="33.%">Process Order Opened</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($results_ as $row) : ?>
              <?php //$status = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $row["Month"])); ?>
              <?php //$fabricator = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $row["Fabricator"])); ?>
              <tr style="padding: 3%" class="btext smallplus <?=$rowcolor?>" status="<?=$status?>" fabricator="<?=$fabricator?>" ntk="<?=$ntk?>" style="height: 30px;">
                <td><?=$row["Year"]?></td>
                <td><?=$row["Month"]?></td>
                <td><?=$row["Process Orders Opened"]?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <div id="table_pages_footer" class="footer" style="width: 47%;">
        <div id="top">
          <div id="filter_container">
            <div id="filters" class="red fill rounded" style="background-color: #8bc34a">
              <div class="filter">
                <div class="text">
                  <button style="background-color: #8bc34a" class="fill red medium wtext">Status</button>
                </div>
                <div class="content">
                  <select disabled id="select_status" class="selector fill medium">
                    <option value="All" selected>All</option>
                    <?php generate_filter_options($results_, "Month"); ?>
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
            <button onclick="location.href='../../../MAIN MENU/dashboard_menu.php'" class="grouping_page_corner_buttons fill medium purple wtext rounded">MAIN MENU</button>
          </div>
          <div id="button_container">
            <button onclick="export_to_excel('intel_pedestal_production')" class="grouping_page_corner_buttons fill medium green wtext rounded">EXPORT</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="background">
    <div id="content">
      <div class="table_title green"style="box-shadow: -3px 3px 6px #03A9F4, 0 1px 4px #03A9F4;">
        <h1>PROCESS ORDER DELIVERED</h1>
      </div>
      <div id="pages_table_container" class="table_container2" style="overflow-y: scroll;box-shadow: -3px 3px 6px #03A9F4, 0 1px 4px #03A9F4;" >
        <table style="background-color: white" id="intel_pedestal_production" class="filterable sortable searchable">
          <thead>
            <tr style="font-size: larger" class="dark_grey btext small head">
              <th width="33.3%">Year</th>
              <th width="33.3%">Month</th>
              <th width="33.%">Process Order Delivered</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($results_1 as $row) : ?>
              <?php //$status = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $row["Status"])); ?>
              <?php //$fabricator = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $row["Fabricator"])); ?>
              <tr style="padding: 3%" class="btext smallplus <?=$rowcolor?>" status="<?=$status?>" fabricator="<?=$fabricator?>" ntk="<?=$ntk?>" style="height: 30px;">
                <td><?=$row["Year"]?></td>
                <td><?=$row["Month"]?></td>
                <td><?=$row["Process Orders Delivered"]?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <div style="height:23%;margin-top:6%;background-color: lightblue;box-shadow: -3px 3px 6px #03A9F4, 0 1px 4px #03A9F4;">
      <canvas id="chart"></canvas>
            </div>
      <div id="table_pages_footer" class="footer" style="width: 47%">
        <div id="top">
          <div id="filter_container">
            <div id="filters" style="background-color: #8bc34a" class="red fill rounded">
              <div class="filter">
                <div class="text">
                  <button disabled style="background-color: #8bc34a" class="fill red medium wtext">Status</button>
                </div>
                <div class="content">
                  <select disabled id="select_status" class="selector fill medium">
                    <option value="All" selected>All</option>
                    <?php generate_filter_options($results_, "Month"); ?>
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
            <button class="grouping_page_corner_buttons fill medium light_blue wtext rounded">UNUSSED <?php //round(($total_executed/$total_planned)*100,2);?></button>
          </div>
          <div id="button_container_wide">
            <button onclick="location.href='../../../MAIN MENU/dashboard_menu.php'" class="grouping_page_corner_buttons fill medium purple wtext rounded">MAIN MENU</button>
          </div>
          <div id="button_container">
            <button onclick="export_to_excel('intel_pedestal_production')" class="grouping_page_corner_buttons fill medium green wtext rounded">EXPORT</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  

  <script>
  // Get data for chart
  var processOrderOpened = <?php echo json_encode($results_); ?>;
  var processOrderDelivered = <?php echo json_encode($results_1); ?>;

  // Filter data for the current year
  var currentYear = new Date().getFullYear();
  var currentYear = new Date().getFullYear().toString();
  var filteredOpened = processOrderOpened.filter(function(item) {
    return item["Year"] === currentYear;
  });

  var filteredDelivered = processOrderDelivered.filter(function(item) {
    return item["Year"] === currentYear;
  });

  // Process the filtered data to create labels and datasets for the chart
  var labels = filteredOpened.map(function(item) {
    return item["Month"];
  });

  var dataOpened = filteredOpened.map(function(item) {
    return item["Process Orders Opened"];
  });

  var dataDelivered = filteredDelivered.map(function(item) {
    return item["Process Orders Delivered"];
  });

  // Create the chart
  var ctx = document.getElementById("chart").getContext("2d");
  var chart = new Chart(ctx, {
    type: "line",
    data: {
      labels: labels,
      datasets: [
        {
          label: "Process Orders Opened",
          data: dataOpened,
          backgroundColor: "rgba(255, 99, 132, 0.2)",
          borderColor: "rgba(255, 99, 132, 1)",
          borderWidth: 1
        },
        {
          label: "Process Orders Delivered",
          data: dataDelivered,
          backgroundColor: "rgba(54, 162, 235, 0.2)",
          borderColor: "rgba(54, 162, 235, 1)",
          borderWidth: 1
        }
      ]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        x: {
          display: true,
          title: {
            display: true,
            text: 'Month'
          }
        },
        y: {
          display: true,
          title: {
            display: true,
            text: 'Number of Orders'
          },
          beginAtZero: true
        }
      },
      plugins: {
        title: {
          display: true,
          text: 'Process Orders Opened/Delivered - Current Year',
          font: {
            size: 18
          }
        }
      }
    }
  });
</script>
</body>
</html>
