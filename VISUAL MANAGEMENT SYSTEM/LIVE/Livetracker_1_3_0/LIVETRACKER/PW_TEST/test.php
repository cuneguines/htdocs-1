<?php
// SECURITY
// IF PASSWORD IS SUBMITTED AND CORRECT ALLOW TO CONTINUE
// IF PASSWORD IS SUBMITTED AND INCORRECT REDIVERT TO LOGIN PAGE WITH ERROR MESSAGE
// IF RELOAD DATA OPTION IS CLICKED REDIVERT TO LOGIN PAGE (ABOVE WILL STILL BE EXECUTED) AND ASK FOR PASSWORD AGAIN
// OTHERWISE REDIVERT TO LOGIN PAGE
if (!isset($_POST['user']) || !isset($_POST['password'])) {
  header("Location:enter_password.php?message=Access Denied");
}

$user = isset($_POST['user']) ? $_POST['user'] : "NO_USER";
$pw = isset($_POST['password']) ? $_POST['password'] : "NO_PASSWORD";

//print($user);
//print($pw);

include '../../PHP LIBS/PHP FUNCTIONS/php_functions.php';
include '../../SQL CONNECTIONS/conn.php';
$query = "select t2.USERID ,t0.U_PDM_Project,t2.U_NAME,t0.SlpCode,t0.U_Est_Eng_Hours,t3.docnum,t3.U_Client from ousr t2 inner join rdr1 t0 on t0.SlpCode=t2.USERID INNER JOIN ordr t3 on t0.DocEntry = t3.DocEntry where t2.USERID= $user";
$query_2="select *,t0.docnum from ordr t0 where t0.DocStatus <> 'C' and t0.CANCELED <> 'Y'";
$results = get_sap_data($conn, $query, DEFAULT_DATA);
$sales_results=get_sap_data($conn, $query_2, DEFAULT_DATA);
foreach ($results as $row) : 
$name = ($row["U_NAME"]);
 endforeach;
$hash = '$2y$10$Bt0CByx9MR2j383l4HaboufmiVUb5cHsG14TXZYKu4U2PhJ2zzfIG';


// USING USER ID GO TO SQL AND RETURN USER NAME AND PASSWORD OF THAT USER 

//$passwords = array ("123" => array("name" => "john", "pw" => '$2y$10$zOA09P6Va0krAG2TpzbvaeykDCe/PRKjWLEDQ8P3hyR/1GnTzq4r6'),
//"456" => array("name" => "bill", "pw" => '$2y$10$LWSsNX477wnZJSrxfaQaI.192LvqLn7UxaBJepvLEik6dOM/H5xuO'));


//$username = $passwords[$user]["name"];
//$u_password = $passwords[$user]["pw"];



//print($user." ".$username." ".$u_password);$pw=123
//print(password_hash($pw, null));

if (password_verify($pw, $hash)) {
  $_SESSION['logged_in'] = 1;
} else {
  header("Location:enter_password.php?message=Access Denied");
}

?>
<!DOCTYPE html>
<html>

<head>
  <!-- INITALISATION AND META STUFF -->
  <title>TABLE LAYOUT</title>
  <meta name="viewpport" content="width=device-width, initial-scale = 1">

  <!-- EXTERNAL JS DEPNDENCIES -->
  <script type="text/javascript" src="../../../JS LIBS/THIRD PARTY/jquery-3.4.1.js"></script>
  <script type="text/javascript" src="../../../JS LIBS/THIRD PARTY/jquery.tablesorter.js"></script>
  <script type="text/javascript" src="../../../JS LIBS/THIRD PARTY/jquery.tablesorter.widgets.js"></script>

  <!-- LOCAL JS DEPENDENCIES -->
  <script type="text/javascript" src="../../../JS LIBS/LOCAL/JS_filters.js"></script>
  <script type="text/javascript" src="../../../JS LIBS/LOCAL/JS_search_table.js"></script>
  <script type="text/javascript" src="./JS_table_to_excel.js"></script>
  <script src="./assets/js/jquery-1.10.2.js"></script>
  <script src="./assets/js/bootstrap.min.js"></script>
  <script src=".assets/js/jquery.min.js"></script>
  <script src="./engr_update.js"></script>

  <!-- STYLING -->
  <link href='../../../CSS/LT_STYLE.css' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="./assets/css/bootstrap.min.css" />
  <link rel="stylesheet" href="../../css/theme.blackice.min.css">
  <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>




</head>
<style>
  @import "compass/css3";

  $sortcols: 'firstName', 'lastName', 'birth';

  %sortcol {
    background: rgba(navy, .15);
    text-shadow: 0 1px #eee;

    &:before {
      box-shadow: 0 0 .5em navy;
    }

    &.prop__name {
      color: lightcyan;

      &[data-dir='1']:after {
        content: '▲';
      }

      &[data-dir='-1']:after {
        content: '▼';
      }
    }
  }


  body,
  html {
    background: #555;

    color: #fff;
    min-height: 100vh;
    margin: 0;
    padding: 0;
  }

  table {

    overflow: hidden;
    margin: 4em auto;
    border-collapse: collapse;
    min-width: 23em;
    width: 70%;
    max-width: 56em;
    border-radius: .5em;
    box-shadow: 0 0 .5em #000;
  }

  thead {
    background: linear-gradient(#606062, #28262b);
    font-weight: 700;
    letter-spacing: 1px;
    text-transform: uppercase;
    cursor: pointer;
  }

  th {
    text-align: left;

  }

  tbody {
    display: flex;
    flex-direction: column;
    color: cornsilk;
  }

  td {
    border: 1px solid greenyellow;
  }

  tr {
    display: block;
    overflow: hidden;
    width: 100%;
  }

  .odd {
    background: linear-gradient(#eee 1px, #ddd 1px, #ccc calc(100% - 1px), #999 calc(100% - 1px));
  }

  .even {
    background: linear-gradient(#eee 1px, #bbb 1px, #aaa calc(100% - 1px), #999 calc(100% - 1px));
  }

  [class*='prop__'] {
    float: left;
    position: relative;
    padding: .5em 1em;
    width: 20%;




  }
</style>
<?php


    
    ?>
<body style="height:100%">

  <div id="sched_right" style="position:relative;height:90%;">
    <div class="table_title green">
      <h1>ENGINEER HOURS UPDATE</h1>
    </div>
    <div style="margin-top:4%"class="container mt-5">
        <div class="card">
       
            <div class="card-body">
                <form role="form" data-toggle="validator">

                    <div class="form-group">
                        <label>Name</label>
                        
                        <label id="name"type="text" class="form-control" data-error="You must have a name."  placeholder="Name" value='<?=$name?>'><?=$name?></label>
                        <input  style="display:none"id="nam"type="text" value='<?=$name?>'>
                        <!-- Error -->
                        <div class="help-block with-errors"></div>
                    </div>
                    
                    <div class="form-group">
                        <label>Project Name</label>
                        <input name="username" type="text" class="form-control"  maxlength="10" minlength="3"
                             id="pr_name"  required>
                            <!-- <input type="pr_name" class="form-control" name="username" maxlength="10" minlength="3"
                            pattern="^[a-zA-Z0-9_.-]*$" id="inputUsername"  required>
                        <!-- Error --> 
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group">
                        <label>Sales Order</label>
                        <select id="sales_order" style=width:100%;height:34px;color:black;>
                                            <option value="All" selected>All</option>
                                            <?php generate_filter_options($sales_results, "docnum"); ?>
                                        </select>
                        <!-- Error -->
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group">
                        <label>PDM Name</label>
                        <div class="form-group">
                            <input type="text" data-minlength="4" class="form-control" id="pdm_name"
                                data-error="Have atleast 4 characters"  required />
                            <!-- Error -->
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    

                    <div class="form-group">
                        <label>Engineer hours</label>
                        <div class="form-group">
                            <input type="number" value="0" class="form-control" id="engr_hrs"
                              required />
                            <!-- Error -->
                            
                        </div>
                    </div>
                    
                    <div class="form-group">
                                    <label for="date">Date</label>
                                    <input id="ddate" name="message" type="date" class="form-control"></textarea>
                                </div>
                    

                    <div class="form-group">
                        <button type="button"id="send"class="btn btn-primary btn-block"onclick="submitt(e)">Send</button>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary btn-block"onclick="viewss()">View</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
</div>
</body>

</html>