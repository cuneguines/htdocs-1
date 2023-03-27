<?php
try {
    // CONNECT TO SEVER WITH PDO SQL SERVER FUNCTION
    $conn = new PDO("sqlsrv:Server=KPTSVSP;Database=LEARNING_LOG", "sa", "SAPB1Admin");
    // CREATE QUERY EXECUTION FUNCTION
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    // REPORT ERROR
    die(print_r($e->getMessage()));
}
?>
<?php
//echo json_encode($_POST);
$item = (!empty($_GET['q']) ? $_GET['q'] : 0);
if (isset($_GET['q']))
    $item = $_GET['q'];
//echo ($item);

$result = "select t0.attachments,
(case 
WHEN  t0.attachments ='' then 'N'  else t0.attachments
END) [attachements_issues]
from ms_qual_log t0
where t0.form_type in( 'Non Conformance','Opportunity For Improvement')
and t0.ID=$item";


$getResults = $conn->prepare($result);
$getResults->execute();
$file_results = $getResults->fetchAll(PDO::FETCH_BOTH);
//print_r($file_results);

foreach ($file_results as $fname) {

    $filename = json_encode($fname[0]);

    //echo ($filename);
    //echo ("<br>");
    $string = $filename;
    $str_arr = preg_split("/\}/", $string);
    //print_r($str_arr);
    //echo ("<br>");
    foreach ($str_arr as $arr)
        if ($arr != ']"') {
            echo ("<br>");
            //echo ($arr);


            $stringParts = explode('name\":\"', $arr);
            echo ("<br>");
            //print_r($stringParts[1]);
            echo ("<br>");

            $stringspliagain = explode('\",\"link', $stringParts[1]);
            error_reporting(E_ERROR | E_PARSE);

            echo ("<br>");
            print_r($stringspliagain[0]);
            $str = str_replace('\\', '/', $stringspliagain[0]);
            ////echo ($str);
            $str = str_replace('//', '/', $str);
            ////echo ($str);
?>
        <a href="https://kentstainlesswex.sharepoint.com/sites/Non_Conformance_Data/Shared%20Documents/<?= $stringspliagain[0] ?>?h=50%&w=10%">Click to view files</a>
        
<?php


        }
}
?>

