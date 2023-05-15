<html>
    <title>Password Protected</title>
    <link rel = "stylesheet" href = "../../css/LT_STYLE.css">
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>
    <body>
        <style>
    body {
  background: #555;
  font: 1em/1.25 trebuchet ms, verdana, sans-serif;
  color: #fff;
  height:100vh;
}
</style>
<?php
include '../../PHP LIBS/PHP FUNCTIONS/php_functions.php';
include '../../SQL CONNECTIONS/conn.php';
$query = "select t0.firstName + ' ' + t0.lastName [Eng_Name]

from ohem t0
inner join ohps t1 on t1.posID = t0.position

where t1.name = 'Engineer'
and t0.Active = 'Y'

order by t0.lastName, t0.firstName
;";
$results = get_sap_data($conn, $query, DEFAULT_DATA);

function generate_filter_optionss($table, $field){
    foreach(array_sort(array_unique(array_column($table, $field))) as $element){
        echo "<option value = '". $element."'>".($element)."</option>";
    }
}
?>
        <div style="margin-top:10%">
            <div style = "width:30%; height:20%; position:relative; vertical-align:top; top:40%; left: 35%; background-color:#ff5c33;">
                <form style = "height:100%;background: linear-gradient(#606062, #28262b); margin:0;" action = "./test.php" method="post">
                
                
                                       
                    <p style =  "text-transform:uppercase;color:white; font-size:20px; margin-bottom:30px;"><br>Enter Userid & Password :</p>
                    <!-- <input style = "font-size:20px; width:30%; height:30%;" type="text" name="user" placeholder = "user"></input> -->
                    <select name="user" style = "font-size:20px; width:30%; height:30%;"id="sales_order">
                                           
                                            <?php generate_filter_optionss($results, "Eng_Name"); ?>
                                           
                                        </select>
                    <input style = "font-size:20px; width:30%; height:30%;" type="password" name="password" placeholder = "password"></input>
                    <input style = "font-size:20px; width:20%; height:30%;" type = "submit" value = "submit">
                    <?php 
                        if(isset($_GET['message'])){
                            echo "<br><p style = 'font-family:sans-serif; color:white; font-size:20px;'>".$_GET['message']."</p>";
                        }
                    ?>
            </div>
        </div>
    </body>
</html>