<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Company</title>
    <!-- Bootstrap Styles-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FontAwesome Styles-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- Morris Chart Styles-->
    <link href="assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
    <!-- Custom Styles-->
    <link href="assets/css/custom-styles.css" rel="stylesheet" />
    <!-- Google Fonts-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <link rel="stylesheet" href="assets/js/Lightweight-Chart/cssCharts.css">
    <script type="text/javascript" src="../../JS LIBS/THIRD PARTY/jquery-3.4.1.js"></script>
    <script type="text/javascript" src="./qualityjs.js"></script>
    <link rel="stylesheet" href="assets/css/table.css">

</head>
<style>
    .active1,
    .btn:hover {
        background-color: rgb(198, 155, 64);
        color: white;
    }

    .nav-second-level {
        overflow-y: scroll;
        max-height: 310px;
    }

    .comment_button.has_comment {
        background-color: rgb(198, 155, 64);
    }

    .comment_button {
        height: 30px;
        width: 40px;
        border: 2px solid #454545;
        background-color: white;
        border-radius: 7px;
        vertical-align: middle;

    }
</style>


<body>
    <?php include './conn.php'; ?>
    <?php include './SQL_Quality_ItemCode.php'; ?>
    <?php
    $getResults = $conn->prepare($Quality_results);
    $getResults->execute();
    $quality_results = $getResults->fetchAll(PDO::FETCH_BOTH);
    //$json_array = array();
    //var_dump($production_exceptions_results);
    //echo json_encode(array($quality_results));
    ?>
    <div id="wrapper">
        <nav class="navbar navbar-default top-navbar" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html"><strong>Company name</strong></a>
            </div>

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                        <i class="fa fa-envelope fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-messages">
                        <li>
                            <a href="#">
                                <div>
                                    <strong>John Doe</strong>
                                    <span class="pull-right text-muted">
                                        <em>Today</em>
                                    </span>
                                </div>
                                <div>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s...
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <strong>John Smith</strong>
                                    <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                                </div>
                                <div>Lorem Ipsum has been the industry's standard dummy text ever since an kwilnw...
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <strong>John Smith</strong>
                                    <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                                </div>
                                <div>Lorem Ipsum has been the industry's standard dummy text ever since the...</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>Read All Messages</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-messages -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                        <i class="fa fa-tasks fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-tasks">
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 1</strong>
                                        <span class="pull-right text-muted">60% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                                            <span class="sr-only">60% Complete (success)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 2</strong>
                                        <span class="pull-right text-muted">28% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="28" aria-valuemin="0" aria-valuemax="100" style="width: 28%">
                                            <span class="sr-only">28% Complete</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 3</strong>
                                        <span class="pull-right text-muted">60% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                                            <span class="sr-only">60% Complete (warning)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 4</strong>
                                        <span class="pull-right text-muted">85% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 85%">
                                            <span class="sr-only">85% Complete (danger)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>See All Tasks</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-tasks -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                        <i class="fa fa-bell fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-comment fa-fw"></i> New Comment
                                    <span class="pull-right text-muted small">4 min</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                    <span class="pull-right text-muted small">12 min</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-envelope fa-fw"></i> Message Sent
                                    <span class="pull-right text-muted small">4 min</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-tasks fa-fw"></i> New Task
                                    <span class="pull-right text-muted small">4 min</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                    <span class="pull-right text-muted small">4 min</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>See All Alerts</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-alerts -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="#"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
        </nav>
        <!--/. NAV TOP  -->
        <nav class="navbar-default navbar-side" role="navigation">
            <div id="sideNav" href=""><i class="fa fa-caret-right"></i></div>
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">

                    <li>
                        <a class="active-menu" href="index.html"><i class="fa fa-dashboard"></i> Dashboard</a>
                    </li>


                    <li>
                        <a id="product_button" href="#"><i class="fa fa-sitemap"></i> Products<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level" style="overflow-y:scroll">
                        


                        </ul>

                    </li>
                    <li>
                        <a id="services_button" href="#"><i class="fa fa-sitemap"></i> Services<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level_services" style="overflow-y:scroll">



                        </ul>

                    </li>
                </ul>
                </li>
                </ul>

            </div>

        </nav>
        <!-- /. NAV SIDE  -->

        <div id="page-wrapper">
            <div class="header">
                <h1 class="page-header">
                    Dashboard <small>Summary of Issues</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Products</a></li>
                    <li class="active">Issues</li>
                </ol>

            </div>
            <div id="page-inner">

                <!-- /. ROW  -->


                <div class="card">
                    <div class="card-header">

                    </div>
                    <div class="card-body" style="overflow-x:scroll;overflow-y:scroll;min-height:800px;max-height:800px; width:100%;">


                        <table id="products" style="position: sticky">
                            <thead style="position:sticky;top:0;z-index:+2">
                                <tr class="head">
                                    <th style="position: sticky;width:100px;left:0px;color:white">ItemCode</th>
                                    <th style="position: sticky;width:100px;left:100px;color:white">ItemName</th>
                                    <th style="position: sticky;width:200px;left:200px;color:white">Issue</th>
                                    <th style="width:100px">CreatedDate</th>

                                    <th style="width: 200px">Raised Area</th>
                                    <th style="width: 500px">Raised By</th>
                                    <th style="width: 200px">ProductGp</th>
                                    <th style="width: 100px;">SubGp2</th>
                                    <th style="width: 300px">SubGp3</th>


                                    <th style="width:200px">RootCauseAnalysis</th>
                                    <th style="width:400px">Previous action reports</th>
                                    <th style="width:300px">Attachements</th>
                                </tr>
                            </thead>
                            <tbody>


                                <?php foreach ($quality_results as $row) : ?>
                                    <tr>
                                        <td style="position: sticky;left:0px;background:#0a8dce"><?= $row["ItemCode"] ?></td>
                                        <td style="position: sticky;left:100px;px;background:#0a8dce"><?= $row["ItemName"] ?></td>
                                        <td style="position: sticky;left:200px;background:#0a8dce"><?= $row["U_nc_observation"] ? $row["U_nc_observation"]  : '--------' ?></td>
                                        </td>
                                        <td><?= $row["CreateDate"] ?></td>

                                        <td><?= $row["U_area_nc"] ?></td>
                                        <td><?= $row["U_area_nc_raised"] ?></td>
                                        <td><?= $row["U_Product_Group_One"] ? $row["U_Product_Group_One"]  : '--------' ?></td>
                                        <td><?= $row["U_Product_Group_Two"] ?></td>
                                        <td class="Group3"><?= $row["U_Product_Group_Three"] ?></td>


                                        <td><?= $row["U_root_cause_analysis"] ?></td>
                                        <td><?= $row["U_prev_action_report"] ?></td>
                                        <td><button style="position:relative;margin-left:37%" class='comment_button <?= $row["attachements_issues"] != 'N' ? 'has_comment' : '' ?>'></button></td>




                                    </tr>
                                <?php endforeach; ?>
                            </tbody>



                        </table>






                    </div>

                </div>
                <!-- Filter Starts here -->

                <div class="filtercontainer" style="background-color: #337ab7;
    width: 100%;
    height: 50px;display:none">
                    <div class="filter">
                        <div class="text">
                            <button style="float:left;width:100px;margin-left:600px;height:40px;margin-top:5px;background-color:#337ab7;border:none;color:white;font-size:medium;" class="medium wtext">By Group1</button>
                        </div>
                        <div class="content" style="float:left;margin-right:40px;">
                            <select class="selector" id="select_group2" style="width:250px;height:40px;margin-top:5px">
                                <option value="All" selected>All</option>

                            </select>
                        </div>

                    </div>
                    <div class="filter">
                        <div class="text">
                            <button style="float:left;width:100px;height:40px;margin-top:5px;border:none;background-color:#337ab7;color:white;font-size:medium;" class="medium wtext">By Group2</button>
                        </div>
                        <div class="content" style="float:left">
                            <select id="select_group3" style="width:250px;height:40px;margin-top:5px">
                                <option value="All" selected>All</option>

                            </select>
                        </div>

                    </div>
                </div>
                <!-- Filter Ends here -->

            </div><br>


        </div><br>



        <!-- <footer>
            <p class="test">All right reserved by <a href="">Company name</a>


        </footer> -->
    </div>
    <!-- /. PAGE INNER  -->
    </div>
    <!-- /. PAGE WRAPPER  -->
    </div>
    <!-- /. WRAPPER  -->
    <!-- JS Scripts-->
    <!-- jQuery Js -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- Bootstrap Js -->
    <script src="assets/js/bootstrap.min.js"></script>

    <!-- Metis Menu Js -->
    <script src="assets/js/jquery.metisMenu.js"></script>
    <!-- Morris Chart Js -->
    <script src="assets/js/morris/raphael-2.1.0.min.js"></script>
    <script src="assets/js/morris/morris.js"></script>


    <script src="assets/js/easypiechart.js"></script>
    <script src="assets/js/easypiechart-data.js"></script>

    <script src="assets/js/Lightweight-Chart/jquery.chart.js"></script>

    <!-- Custom Js -->
    <script src="assets/js/custom-scripts.js"></script>

    <script>

    </script>

</body>

</html>