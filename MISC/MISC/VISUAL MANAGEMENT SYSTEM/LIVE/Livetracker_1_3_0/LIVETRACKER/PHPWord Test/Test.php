<?php


require "autoload.php";
//echo "test!!!!!!!";
$content = '';

if(isset($_POST['content']))
{
	$content = $_POST['content'];
}


if(isset($_POST['mode']))
{

//	echo "mode parameter found";
	$mode = $_POST['mode'];

//	echo "mode = " . $mode;

	if($mode == "read")
	{ 
//		echo "mode is read";	

		$content = '';

		//require_once dirname(__FILE__) . '/includes/phpoffice/vendor/autoload.php';
		$phpWord = \PhpOffice\PhpWord\IOFactory::load('Quality Issue1.docx');
		//$phpWord = new \PhpOffice\PhpWord\PhpWord();

		foreach($phpWord->getSections() as $section) 
		{
		    foreach($section->getElements() as $element) 
		    {
		        if (method_exists($element, 'getElements')) 
			{
            		    foreach($element->getElements() as $childElement) {
                		if (method_exists($childElement, 'getText')) {
                    			$content .= $childElement->getText() . ' ';
                		}
                		else if (method_exists($childElement, 'getContent')) {
                    	    		$content .= $childElement->getContent() . ' ';
                		}
        	    	    }
        		}
		        else if (method_exists($element, 'getText')) {
            			$content .= $element->getText() . ' ';
        		}
    		    }
		}
	}
	if($mode == "write") 
	{
//		echo "mode is write";	


		$phpWord = new \PhpOffice\PhpWord\PhpWord();
		PhpOffice\PhpWord\Settings::setOutputEscapingEnabled(true);

		/* Note: any element you append to a document must reside inside of a Section. */

		// Adding an empty Section to the document...
		$section = $phpWord->addSection();
		// Adding Text element to the Section having font styled by default...
//		$section->addText(
//		    '"Learn from yesterday, live for today, hope for tomorrow. '
//		        . 'The important thing is not to stop questioning." '
//		        . '(Albert Einstein)'
//		);
		$section->addText($content);

		// Saving the document as OOXML file...
		$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
		$objWriter->save('Quality Issue1.docx');

/* Note: we skip RTF, because it's not XML-based and requires a different example. */
/* Note: we skip PDF, because "HTML-to-PDF" approach is used to create PDF documents. */



//include_once 'Sample_Header.php';

// Read contents
//$name = basename(__FILE__, '.php');
//$source = __DIR__ . "/HelloWorld.docx";

//echo date('H:i:s'), " Reading contents from `{$source}`", EOL;
//$phpWord = \PhpOffice\PhpWord\IOFactory::load($source);

// Save file
//echo write($phpWord, basename(__FILE__, '.php'), $writers);
//if (!CLI) {
//    include_once 'Sample_Footer.php';
//}




	}
}
else
{
	$mode = "read";
}


?>
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
    
<script type="text/javascript" src="../../JS LIBS/THIRD PARTY/jquery-3.4.1.js"></script>
    
<!-- <script type="text/javascript" src="./qualityjs.js"></script> -->
    
<script type="text/javascript" src="./keep_safe.js"></script>
    
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

</style>



<body>



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

                        <i class="fa fa-envelope fa-fw"></i>
			<i class="fa fa-caret-down"></i>

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

                        <i class="fa fa-tasks fa-fw"></i> 
			<i class="fa fa-caret-down"></i>

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

                        <a class="active-menu" href=""><i class="fa fa-dashboard"></i> Dashboard</a>

                    </li>



                    <li>

                        <a id="product_button" href="#"><i class="fa fa-sitemap"></i> Products<span class="fa arrow"></span></a>


                        <ul class="nav nav-second-level" data-toggle="collapse" aria-expanded="true" data-target=".nav-third-level" style="overflow-y:scroll">



                        </ul>


                    </li>

                    <li>

                        <a id="services_button" href="#"><i class="fa fa-ambulance"></i> Health and Safety<span class="fa arrow"></span></a>

                        <ul class="nav nav-second-level_services" style="overflow-y:scroll">




                        </ul>


                    </li>

                    <li>

                        <a id="services_button" href="#"><i class="fa fa-search"></i> Audit findings<span class="fa arrow"></span></a>

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

                   <small>Summary of Issues</small>

                </h1>

                <ol class="breadcrumb non_confirmance">

                    <li><a href="index.php">Home</a></li>

                    <li><a href="chart_page.php">Charts</a></li>

                    <li><a href="edit_page.php">Edit</a></li>

                    <li class="active">Issues</li>

                </ol>


            </div>

            <div id="page-inner">


                <!-- /. ROW  -->



                <div class="card">

                    <div class="card-header">


                    </div>

                    <div class="card-body" id="card_body1" style="box-shadow: 0px -5px 10px 0px rgba(0, 0, 0, 0.5);overflow-x:scroll;overflow-y:scroll;height:68vh; width:100%;">







                    <div class="modal-dialog">

                        <div class="modal-content" id="modal_content">






<form action="Test.php" method="post" enctype="multipart/form-data">
<div class="form-group">
<table id="products" style="position: sticky;overflow-x:scroll;">

<tr>
<td width="10%">
content: 
</td>
<td width="90%">

<textarea type="text"
       cols="40" 
       rows="5" 
       style="width:500px; height:150px;" 
       name="content" 
       id="content" 
><?php echo $content ?></textarea>



</td>
</tr>

<tr>
<tr>
<td>
<input type="hidden" name="mode" value="write"/>
</td>
<td>
<input type="submit" class="btn btn-primary" value="write">
</td>
</tr>
</table>
</form>


<form action="Test.php" method="post">
<div class="form-group">
<table id="products" style="position: sticky;overflow-x:scroll;" border="1">

<tr>
<td>
<input type="hidden" name="mode" value="read"/>
</td>
<td>
<input type="submit" class="btn btn-primary" value="Read"> 
</td>
</tr>
</table>
</form>


                    </div>

                </div>







                <!-- Filter Starts here -->


                <!-- modal starts here  -->

                <div id="dataModal" class="modal fade">

                    <div class="modal-dialog">

                        <div class="modal-content" id="modal_content">

                            <div class="modal-header">

                                <button type="button" class="close" data-dismiss="modal">&times;</button>

                                <h4 class="modal-title">Details</h4>

                            </div>

                            <div class="modal-body" id="attachments">















                            </div>

                            <div class="modal-footer">

                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                            </div>

                        </div>

                    </div>

                </div>

                <!-- Modal end here -->


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

    <!--script src="assets/js/morris/raphael-2.1.0.min.js"></script-->

    <!--script src="assets/js/morris/morris.js"></script-->



    <!--script src="assets/js/easypiechart.js"></script-->

    <!--script src="assets/js/easypiechart-data.js"></script-->


    <!--script src="assets/js/Lightweight-Chart/jquery.chart.js"></script-->


    <!-- Custom Js -->

    <!--script src="assets/js/custom-scripts.js"></script-->





</body>


</html>