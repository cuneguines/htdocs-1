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
    <script type="text/javascript" src="./THIRD PARTY/jquery-3.4.1.js"></script>
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
                        <a id="product_button" ><i class="fa fa-sitemap"></i> Non Conformance<span class="fa arrow"></span></a>

                        <ul class="nav nav-second-level" data-toggle="collapse" aria-expanded="true" data-target=".nav-third-level" style="overflow-y:scroll">


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
                <ol class="breadcrumb">
                    
                    <li><a href="edit_page.php">Forms</a></li>
                    <li><a href="updated_page.php">Newpage</a></li>
                    <li class="active">Table</li>
                </ol>

            </div>
            <div id="page-inner_one">

                <!-- /. ROW  -->


                <div class="card">
                    <div class="card-header">

                    </div>
                    <div class="card-body" id="card_body1" style="box-shadow: 0px -5px 10px 0px rgba(0, 0, 0, 0.5);overflow-x:scroll;overflow-y:scroll;height:65vh; width:100%;">


                        <table id="products" style="position: sticky;overflow-x:scroll;">
                            <thead style="position:sticky;top:0;z-index:+2">
                                <tr class="head">
                                    <th style="position: sticky;width:100px;left:0px;color:white;padding-left:3px">Code</th>
                              <th style="position: sticky;width:100px;left:100px;color:white">ItemCode</th>
                                    <th style="position: sticky;width:300px;left:200px;color:white">Issue</th>
                                   
                                   
                                    <th style="width:100px">Sales order</th>
                                    <th style="width:100px">Process order</th>

                                   
                                    
                                    <th style="width: 200px">Area Non Conformance Raised</th>
                                    <th style="width: 100px">Raised By</th>
                                    <th style="width: 200px">Status</th>
                                    <th style="width: 90px">Edit</th>
                                    <!-- <th style="width: 200px">cc_name</th>
                                    <th style="width: 200px">cc_sales_order</th>
                                    <th style="width: 200px">cc_process_order</th>
                                    <th style="width: 200px">cc_itemcode</th>
                                    <th style="width: 200px">cc_raised_by</th>
                                     -->
                                    <!-- <th style="width: 100px">ProductGp</th>
                                    <th style="width: 100px;">SubGp2</th>
                                    <th style="width: 100px">SubGp3</th> -->

                                    <!-- <th style="width: 200px">PrevActionOwner</th>
                                    <th style="width:200px">Type</th>
                                    <th style="width:200px">Status</th>
                                    <th style="width:200px">RootCauseAnalysis</th>
                                    <th style="width:200px">Preventive action reports</th> -->
                                    
                                    <th style="width:200px;"> Attachements</th>
                                </tr>
                            </thead>
                           


                                <?php foreach ($quality_results_nc as $row) : ?>
                                    <tr>
                                        <td style="position: sticky;left:0px;background:#a6cbf7;text-align:center"><?= $row["ID"] ?></td>
                                        <td style="position: sticky;left:100px;px;background:#a6cbf7;text-align:center"><?= $row["nc_itemcode"]?></td>
                                        <td class="bold"style="position: sticky;left:200px;background:#a6cbf7"><?= $row["nc_description"] ? $row["nc_description"]  : '--------' ?></td>
                                       
                                        
                                        <td style="text-align:center"><?= $row["nc_sales_order"] ?></td>
                                        <td style="text-align:center"><?= $row["nc_process_order"] ?></td>
                                        
                                        
                                        <td><?= $row["nc_area_caused"] ?></td>
                                        <td><?= $row["nc_raised_by"] ?></td>
                                        <td><?= $row["Status"] ?></td>
                                        <td><div id="contact"><button type="button" class="btn btn-info btn" data-toggle="modal" data-target="#contact-modal" onclick="myFunction(event)">Update</button></div></td>
                                       <!--  <td><?// $row["cc_sales_order"] ?></td>
                                        <td><?//$row["cc_process_order"] ?></td>
                                        <td><// $row["cc_itemcode"] ?></td>
                                        <td><?//$row["cc_raised_by"] ?></td> -->
                                      
                               
                                        
                                       
                                        <!-- <td class="Group1"><?// $row["U_Product_Group_One"] ? $row["U_Product_Group_One"]  : '--------' ?></td>
                                        <td class="Group2"><?// $row["U_Product_Group_Two"] ?></td>
                                        <td class="Group3"><?// $row["U_Product_Group_Three"] ?></td>
                                        <td><?//$row["U_prev_action_owner"] ?></td>
                                        <td><?//$row["form_type"] ?></td>
                                        <td><// $row["U_Status"] ?></td>

                                        <?
                                        //$uploadfile = file_get_contents(data_uri('//Kptsvsp\b1_shr/Attachments/PHOTO-2022-06-21-12-22-16.jpg', 'image/jpg'));
                                        //echo $uploadfile; ?> -->

                                       <!--  <td><input type="button" onclick=location.href="files_view_cause.php?q=<?// $row['code'] ?>" name='<?// $row["code"] ?>' id='<?// $row["attachments_cause_analysis"] ?>' value='<?= '' ?>' style="position:relative;margin-left:37%" class='comment_button <?// $row["attachments_cause_analysis"] != 'N' ? 'has_attachment' : '' ?>'></td>
                                        
                                       <td><input type="button" onclick=location.href="files_view_prev.php?q=<?// $row['code'] ?>" value='<?= '' ?>' style="position:relative;margin-left:37%" class='comment_button <?// $row["attachments_preve_action"] != 'N' ? 'has_attachment' : '' ?>'></td> -->
                                       <?php
                                       $x=$row["ID"];
                                       //print_r('NON CONFIRMANCE');
                                       ?>
                                        <td><input type="button" onclick=location.href="files_view_issue%20copy.php?q=<?=trim($row['ID'])?>" style="position:relative;margin-left:37%" class='comment_button <?= $row["attachements_issues"] != 'N'? 'has_attachment' : '' ?>'></td>
                                        



                                    </tr>
                                <?php endforeach; ?>
                            </tbody>



                        </table>
                        
                        






                    </div>
                   

                </div>
                <!-- MODAL STARTS HERE -->
                <!-- <div id="contact"><button type="button" class="btn btn-info btn" data-toggle="modal" data-target="#contact-modal">Update</button></div> -->
                <div id="contact-modal" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <a class="close" data-dismiss="modal">×</a>
                                <h3>Status Form</h3>
                            </div>
                            
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="name">ID</label>
                                        <input id="id"type="text" name="name" class="form-control" readonly>
                                        <a href="mailto:cnixon@kentstainless.com?subject=Subscribe&body=Lastame%20%3A%0D%0AFirstname%20%3A">click</a>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Owner</label>
                                        
                                        <select id="owner" style=width:100%;height:34px>
                                        <option value="cnixon@kentstainless.com" selected>cnixon@kentstainless.com</option>
                                       
                                        
                                        
                                </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="email">Required Action</label>
                                        
                                        <select id="action" style=width:100%;height:34px>
                                        <option value="Toolbox Talk" selected>Toolbox Talk</option>
                                        <option value="Eight Disciplines Process" selected>Eight Disciplines Process</option>
                                        
                                     </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        
                                        <select id="status" style=width:100%;height:34px>
                                        <option value="Cancelled" selected>Cancelled</option>
                                        <option value="Open" selected>Open</option>
                                        <option value="Closed" selected>Closed</option>
                                        
                                        
                                     </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="message">Date</label>
                                        <input id="ddate"name="message" type = "date" class="form-control"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="message">Attachments</label>
        <!-- <a href="https://kentstainlesswex.sharepoint.com/sites/Non_Conformance_Data/Shared%20Documents/"><br>Attachments</a> -->
        <input id="sortpicture" type="file" name="sortpic" />
                                    </div>
                                </div>
                                <div class="modal-footer">
                                
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal" onclick="submit()">Submit</button>
                                </div>
                          
                        </div>
                    </div>
                </div>
                <!-- Modal ENDS HERE -->
                <!-- Filter Starts here -->

                <div class="filtercontainer" style="background-color: #0866c6;box-shadow: 0px -5px 10px 0px rgba(0, 0, 0, 0.5);
                             width: 100%;
                             height: 50px;">
                    <div class="filter">
                        <div class="text">
                            <button style="float:left;width:100px;margin-left:30%;height:40px;margin-top:5px;background-color:#0866c6;border:none;color:white;font-size:medium;" class="medium wtext">By Group1</button>
                        </div>
                        <div class="content" style="float:left;margin-right:40px;">
                            <select class="selector" id="select_group2" style="width:250px;height:40px;margin-top:5px">
                                <option value="All" selected>All</option>

                            </select>
                        </div>

                    </div>
                    <div class="filter">
                        <div class="text">
                            <button style="float:left;width:100px;height:40px;margin-top:5px;border:none;background-color:#0866c6;color:white;font-size:medium;" class="medium wtext">By Group2</button>
                        </div>
                        <div class="content" style="float:left">
                            <select id="select_group3" style="width:250px;height:40px;margin-top:5px">
                                <option value="All" selected>All</option>

                            </select>
                        </div>

                    </div>
                </div>
                <!-- Filter Ends here -->


        </div>

<div id="page-inner_two"style=display:none;>

  <!-- /. ROW  -->


  <div class="card">
    <div class="card-header">

    </div>
    <div class="card-body" id="card_body1" style="box-shadow: 0px -5px 10px 0px rgba(0, 0, 0, 0.5);overflow-x:scroll;overflow-y:scroll;height:65vh; width:100%;">


        <table id="products" style="position: sticky;overflow-x:scroll;">
            <thead style="position:sticky;top:0;z-index:+2">
                <tr class="head">
                    <th style="position: sticky;width:100px;left:0px;color:white;padding-left:3px">Code</th>
              <th style="position: sticky;width:200px;left:100px;color:white">ItemName</th>
                    <th style="position: sticky;width:200px;left:300px;color:white">Issue</th>
                   
                    <th style="width:100px">ItemCode</th>
                    <th style="width:200px">Sales order</th>
                    <th style="width:200px">Process order</th>

                    <th style="width:100px">Completion time</th>
                    
                    <th style="width: 200px">Raised Area</th>
                    <th style="width: 100px">Raised By</th>
                    <!-- <th style="width: 200px">cc_name</th>
                    <th style="width: 200px">cc_sales_order</th>
                    <th style="width: 200px">cc_process_order</th>
                    <th style="width: 200px">cc_itemcode</th>
                    <th style="width: 200px">cc_raised_by</th>
                     -->
                    <!-- <th style="width: 100px">ProductGp</th>
                    <th style="width: 100px;">SubGp2</th>
                    <th style="width: 100px">SubGp3</th> -->

                    <!-- <th style="width: 200px">PrevActionOwner</th>
                    <th style="width:200px">Type</th>
                    <th style="width:200px">Status</th>
                    <th style="width:200px">RootCauseAnalysis</th>
                    <th style="width:200px">Preventive action reports</th> -->
                    
                    <th style="width:200px">Attachements</th>
                </tr>
            </thead>
           


                <?php foreach ($quality_results_cc as $row) : ?>
                    <tr>
                        <td style="position: sticky;left:0px;background:#a6cbf7"><?= $row["ID"] ?></td>
                        <td style="position: sticky;left:100px;px;background:#a6cbf7"><?= $row["email"] ?></td>
                        <td style="position: sticky;left:300px;background:#a6cbf7"><?= $row["nc_description"] ? $row["nc_description"]  : '--------' ?></td>
                       
                        <td><?= $row["nc_itemcode"] ?></td>
                        <td><?= $row["nc_sales_order"] ?></td>
                        <td><?= $row["nc_process_order"] ?></td>
                        <td><?= $row["completion_time"] ?></td>
                        
                        <td><?= $row["nc_area_caused"] ?></td>
                        <td><?= $row["nc_raised_by"] ?></td>
                       <!--  <td><?// $row["cc_sales_order"] ?></td>
                        <td><?//$row["cc_process_order"] ?></td>
                        <td><// $row["cc_itemcode"] ?></td>
                        <td><?//$row["cc_raised_by"] ?></td> -->
                      
               
                        
                       
                        <!-- <td class="Group1"><?// $row["U_Product_Group_One"] ? $row["U_Product_Group_One"]  : '--------' ?></td>
                        <td class="Group2"><?// $row["U_Product_Group_Two"] ?></td>
                        <td class="Group3"><?// $row["U_Product_Group_Three"] ?></td>
                        <td><?//$row["U_prev_action_owner"] ?></td>
                        <td><?//$row["form_type"] ?></td>
                        <td><// $row["U_Status"] ?></td>

                        <?
                        //$uploadfile = file_get_contents(data_uri('//Kptsvsp\b1_shr/Attachments/PHOTO-2022-06-21-12-22-16.jpg', 'image/jpg'));
                        //echo $uploadfile; ?> -->

                       <!--  <td><input type="button" onclick=location.href="files_view_cause.php?q=<?// $row['code'] ?>" name='<?// $row["code"] ?>' id='<?// $row["attachments_cause_analysis"] ?>' value='<?= '' ?>' style="position:relative;margin-left:37%" class='comment_button <?// $row["attachments_cause_analysis"] != 'N' ? 'has_attachment' : '' ?>'></td>
                        
                       <td><input type="button" onclick=location.href="files_view_prev.php?q=<?// $row['code'] ?>" value='<?= '' ?>' style="position:relative;margin-left:37%" class='comment_button <?// $row["attachments_preve_action"] != 'N' ? 'has_attachment' : '' ?>'></td> -->
                       <?php
                       $x=$row["ID"];
                       print_r($x);
                       ?>
                        <td><input type="button" onclick=location.href="files_view_issue.php?q=<?=trim($row['ID'])?>" style="position:relative;margin-left:37%" class='comment_button <?= $row["attachements_issues"] != 'N'? 'has_attachment' : '' ?>'></td>
                        



                    </tr>
                <?php endforeach; ?>
            </tbody>



        </table>
        
        






    </div>
   

   </div>

   <!-- Filter Starts here -->

  <div class="filtercontainer" style="background-color: #0866c6;box-shadow: 0px -5px 10px 0px rgba(0, 0, 0, 0.5);
             width: 100%;
             height: 50px;">
    <div class="filter">
        <div class="text">
            <button style="float:left;width:100px;margin-left:30%;height:40px;margin-top:5px;background-color:#0866c6;border:none;color:white;font-size:medium;" class="medium wtext">By Group1</button>
        </div>
        <div class="content" style="float:left;margin-right:40px;">
            <select class="selector" id="select_group2" style="width:250px;height:40px;margin-top:5px">
                <option value="All" selected>All</option>

            </select>
        </div>

    </div>
    <div class="filter">
        <div class="text">
            <button style="float:left;width:100px;height:40px;margin-top:5px;border:none;background-color:#0866c6;color:white;font-size:medium;" class="medium wtext">By Group2</button>
        </div>
        <div class="content" style="float:left">
            <select id="select_group3" style="width:250px;height:40px;margin-top:5px">
                <option value="All" selected>All</option>

            </select>
        </div>

    </div>
  </div>
 <!-- Filter Ends here -->


</div>
<div id="page-inner_three"style=display:none;>

  <!-- /. ROW  -->


  <div class="card">
    <div class="card-header">

    </div>
    <div class="card-body" id="card_body1" style="box-shadow: 0px -5px 10px 0px rgba(0, 0, 0, 0.5);overflow-x:scroll;overflow-y:scroll;height:65vh; width:100%;">


        <table id="products" style="position: sticky;overflow-x:scroll;">
            <thead style="position:sticky;top:0;z-index:+2">
                <tr class="head">
                    <th style="position: sticky;width:100px;left:0px;color:white;padding-left:3px">ACCcategory</th>
              <th style="position: sticky;width:200px;left:100px;color:white">Desciption</th>
                    <th style="position: sticky;width:200px;left:300px;color:white">Location</th>
                   
                    <th style="width:100px">Treatment</th>
                    <th style="width:200px">Treated By</th>
                    <!-- <th style="width:200px">Process order</th>

                    <th style="width:100px">Completion time</th>
                    
                    <th style="width: 200px">Raised Area</th>
                    <th style="width: 100px">Raised By</th> -->
                    <!-- <th style="width: 200px">cc_name</th>
                    <th style="width: 200px">cc_sales_order</th>
                    <th style="width: 200px">cc_process_order</th>
                    <th style="width: 200px">cc_itemcode</th>
                    <th style="width: 200px">cc_raised_by</th>
                     -->
                    <!-- <th style="width: 100px">ProductGp</th>
                    <th style="width: 100px;">SubGp2</th>
                    <th style="width: 100px">SubGp3</th> -->

                    <!-- <th style="width: 200px">PrevActionOwner</th>
                    <th style="width:200px">Type</th>
                    <th style="width:200px">Status</th>
                    <th style="width:200px">RootCauseAnalysis</th>
                    <th style="width:200px">Preventive action reports</th> -->
                    
                    <th style="width:200px">Attachements</th>
                </tr>
            </thead>
           


                <?php foreach ($quality_results_hs as $row) : ?>
                    <tr>
                        <td style="position: sticky;left:0px;background:#a6cbf7"><?= $row["acc_category"] ?></td>
                        <td style="position: sticky;left:100px;px;background:#a6cbf7"><?= $row["acc_description"] ?></td>
                        <td style="position: sticky;left:300px;background:#a6cbf7"><?= $row["acc_location"] ? $row["acc_location"]  : '--------' ?></td>
                       
                        <td><?= $row["acc_treatment"] ?></td>
                       <td><?= $row["acc_treated_by"] ?></td>
                        <!--<td><? //$row["nc_process_order"] ?></td>
                        <td><? //$row["completion_time"] ?></td>
                        
                        <td><?//$row["nc_area_caused"] ?></td>
                        <td><?//$row["nc_raised_by"] ?></td> -->
                       <!--  <td><?// $row["cc_sales_order"] ?></td>
                        <td><?//$row["cc_process_order"] ?></td>
                        <td><// $row["cc_itemcode"] ?></td>
                        <td><?//$row["cc_raised_by"] ?></td> -->
                      
               
                        
                       
                        <!-- <td class="Group1"><?// $row["U_Product_Group_One"] ? $row["U_Product_Group_One"]  : '--------' ?></td>
                        <td class="Group2"><?// $row["U_Product_Group_Two"] ?></td>
                        <td class="Group3"><?// $row["U_Product_Group_Three"] ?></td>
                        <td><?//$row["U_prev_action_owner"] ?></td>
                        <td><?//$row["form_type"] ?></td>
                        <td><// $row["U_Status"] ?></td>

                        <?
                        //$uploadfile = file_get_contents(data_uri('//Kptsvsp\b1_shr/Attachments/PHOTO-2022-06-21-12-22-16.jpg', 'image/jpg'));
                        //echo $uploadfile; ?> -->

                       <!--  <td><input type="button" onclick=location.href="files_view_cause.php?q=<?// $row['code'] ?>" name='<?// $row["code"] ?>' id='<?// $row["attachments_cause_analysis"] ?>' value='<?= '' ?>' style="position:relative;margin-left:37%" class='comment_button <?// $row["attachments_cause_analysis"] != 'N' ? 'has_attachment' : '' ?>'></td>
                        
                       <td><input type="button" onclick=location.href="files_view_prev.php?q=<?// $row['code'] ?>" value='<?= '' ?>' style="position:relative;margin-left:37%" class='comment_button <?// $row["attachments_preve_action"] != 'N' ? 'has_attachment' : '' ?>'></td> -->
                       <?php
                       $x=$row["ID"];
                       //print_r($x);
                       ?>
                        <td><input type="button" onclick=location.href="files_view_issue.php?q=<?=trim($row['ID'])?>" style="position:relative;margin-left:37%" class='comment_button <?= $row["attachements_issues"] != 'N'? 'has_attachment' : '' ?>'></td>
                        



                    </tr>
                <?php endforeach; ?>
            </tbody>



        </table>
        
        






    </div>
   

   </div>

   <!-- Filter Starts here -->

  <div class="filtercontainer" style="background-color: #0866c6;box-shadow: 0px -5px 10px 0px rgba(0, 0, 0, 0.5);
             width: 100%;
             height: 50px;">
    <div class="filter">
        <div class="text">
            <button style="float:left;width:100px;margin-left:30%;height:40px;margin-top:5px;background-color:#0866c6;border:none;color:white;font-size:medium;" class="medium wtext">By Group1</button>
        </div>
        <div class="content" style="float:left;margin-right:40px;">
            <select class="selector" id="select_group2" style="width:250px;height:40px;margin-top:5px">
                <option value="All" selected>All</option>

            </select>
        </div>

    </div>
    <div class="filter">
        <div class="text">
            <button style="float:left;width:100px;height:40px;margin-top:5px;border:none;background-color:#0866c6;color:white;font-size:medium;" class="medium wtext">By Group2</button>
        </div>
        <div class="content" style="float:left">
            <select id="select_group3" style="width:250px;height:40px;margin-top:5px">
                <option value="All" selected>All</option>

            </select>
        </div>

    </div>
  </div>
 <!-- Filter Ends here -->


</div>
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