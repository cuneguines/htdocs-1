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
$results = get_sap_data($conn, $query, DEFAULT_DATA);
//$name = ($results[0]["U_NAME"]);
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

<body style="height:100%">

  <div id="sched_right" style="position:relative;height:90%;">
    <div class="table_title green">
      <h1>ENGINEER HOURS UPDATE</h1>
    </div>
    <div style="background-color:grey;position:relative;height:700px;width:100%;overflow-y:scroll">
      <table>
        <thead>
          <tr>
            <th class='prop__name' data-prop-name='firstName'>First Name</th>
            <th class='prop__name' data-prop-name='lastName'>Project Name</th>
            <th class='prop__name' data-prop-name='sales'>Sales Order</th>
            <th class='prop__name' data-prop-name='birth'>Engineer Hours</th>
            <th class='prop__name' data-prop-name='birth'>Changes</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach $results as $row:?>
            <tr>
              <td class='prop__name' data-prop-name='firstName'><?= $row["U_NAME"] ?></td>
              <td class='prop__name' data-prop-name='lastName'><?= $row["U_PDM_Project"] == NULL ? 'null' : $row["U_PDM_Project"] ?></td>
              <td class='prop__name' data-prop-name='lastName'><?= $row["docnum"] ?></th>
              <td class='prop__name' data-prop-name='birth'><?= $row["U_Est_Eng_Hours"] == NULL ? 'null' : $row["U_Est_Eng_Hours"] ?></td>
              <td style="padding-left: 40px;padding-right:40px;">
                <div id="contact"><button type="button" style="text-align: center" class="btn btn-info btn" data-toggle="modal" data-target="#contact-modal" onclick="myFunction(event)">Update</button></div>
              </td>
            <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <div>
      <div id="contact-modal" class="modal fade" role="dialog" style="color:black">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <a class="close" data-dismiss="modal">×</a>
              <h3>EDIT FORM</h3>
            </div>
            <form id="contactForm" name="contact" role="form">
              <div class="modal-body">
                <div class="form-group">
                  <label for="name">Name</label>
                  <input id="name" type="text" name="name" class="form-control">
                </div>
                <div class="form-group">
                  <label for="email">Enginner Hours</label>
                  <input type="email" name="email" class="form-control">
                </div>

              </div>
              <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-success" onclick="submitt()">Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>