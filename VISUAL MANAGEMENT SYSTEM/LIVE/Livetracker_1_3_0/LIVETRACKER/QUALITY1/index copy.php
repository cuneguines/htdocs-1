<!DOCTYPE html>
<html style="overflow:hidden"xmlns="http://www.w3.org/1999/xhtml">

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
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script> -->
   
    <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> -->
    <!-- <script type="text/javascript" src="../../JS/LIBS/jquery-3.4.1.js"></script> -->
    <script type="text/javascript" src="../../JS LIBS/THIRD PARTY/jquery-3.4.1.js"></script>
    <!-- <script type="text/javascript" src="./qualityjs.js"></script> -->
    <script type="text/javascript" src="./new.js"></script>
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

    .comment_button.has_attachment {
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

    .lefttext{  text-align:left; padding-left:10px;}
.righttext{ text-align:right; padding-right:10px;}
.bold{      font-weight:bold;}
</style>


<body>
    <script>
        function isImage(url) {
        return /\.(jpg|jpeg|png|webp|avif|gif|svg)$/.test(url);
      }
   //url = "https://kentstainlesswex-my.sharepoint.com/personal/cnixon_kentstainless_com/_layouts/15/Doc.aspx?sourcedoc=%7BEA2E3B33-633B-46AA-A9DB-BB5D3698B61B%7D&file=Root%20cause%20and%20Corrective%20Document_Cuneguines%20Nixon.docx";
   ////https://kentstainlesswex-my.sharepoint.com/personal/cnixon_kentstainless_com/Documents/Apps/Microsoft%20Forms/Untitled%20form%201/Question/dUBr2Is_Cuneguines%20Nixon.png

        ////console.log(isImage('https://kentstainlesswex-my.sharepoint.com/personal/cnixon_kentstainless_com/_layouts/15/Doc.aspx?sourcedoc=%7BEA2E3B33-633B-46AA-A9DB-BB5D3698B61B%7D&file=Root%20cause%20and%20Corrective%20Document_Cuneguines%20Nixon.docx'));
        ////console.log(extension);
        </script>
<?php
	try
	{
		// CONNECT TO SEVER WITH PDO SQL SERVER FUNCTION
		$conn = new PDO("sqlsrv:Server=KPTSVSP;Database=LEARNING_LOG","sa","SAPB1Admin");
		// CREATE QUERY EXECUTION FUNCTION
		$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch(Exception $e)
	{
		// REPORT ERROR
		die(print_r($e->getMessage()));
	}
?>
    <?php include './SQL_Quality_ItemCode.php'; ?>
    <?php
    $getResults = $conn->prepare($Quality_results_non_conformance);
    $getResults->execute();
    $quality_results_nc= $getResults->fetchAll(PDO::FETCH_BOTH);
    $getResults = $conn->prepare($Quality_results_customer_complaints);
    $getResults->execute();
    $quality_results_cc = $getResults->fetchAll(PDO::FETCH_BOTH);
    $getResults = $conn->prepare($Quality_results_health_safety);
    $getResults->execute();
    $quality_results_hs = $getResults->fetchAll(PDO::FETCH_BOTH);
    //$json_array = array();
    //var_dump($production_exceptions_results);
    //echo json_encode(array($quality_results));
    function data_uri($file, $mime)
    {
        $contents = file_get_contents($file);
        $base64 = base64_encode($contents);
        return ('data:' . $mime . ';base64,' . $base64);
    }
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
                <a class="navbar-brand" href=""><strong>KENT STAINLESS</strong></a>
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
                        <a id="product_button" onclick = "location.href='non_conformance/non.php'"><i class="fa fa-sitemap"></i> Non Conformance<span class="fa arrow"></span></a>

                        <ul class="nav nav-second-level" data-toggle="collapse" aria-expanded="true" data-target=".nav-third-level" style="overflow-y:scroll">


                        </ul>

                    </li>
                    <li>
                        <a id="services_button_cc" onclick = "location.href='customer_complaints/non.php'"><i class="fa fa-users"></i> Customer complaints<span class="fa arrow"></span></a>
                     <ul class="nav nav-second-level_services" style="overflow-y:scroll"> 



                        </ul>

                    </li>
                    <li>
                        <a id="services_button_hs" href="#"><i class="fa fa-ambulance"></i> Health and Safety<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level_services" style="overflow-y:scroll">



                        </ul>

                    </li>
                    <li>
                        <a id="services_button" href="#"><i class="fa fa-search"></i> Audit Findings<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level_services" style="overflow-y:scroll">



                        </ul>

                    </li>
                    <li>
                        <a id="services_button" href="#"><i class="fa fa-lightbulb-o"></i> Improvement Ideas<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level_services" style="overflow-y:scroll">



                        </ul>

                    </li>
                    
                </ul>
                </li>
                </ul>

            </div>

        </nav>
        <!-- /. NAV SIDE  -->

        <div id="page-wrapper" >
            <div class="header">
                <h1 class="page-header">
                   <small>QUALITY MANAGEMENT SYSTEM</small>
                </h1>
                
    
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