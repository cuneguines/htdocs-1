<?php include '../../SQL CONNECTIONS/conn.php'; ?>
<?php
//echo json_encode($_POST);
$item = (!empty($_GET['q']) ? $_GET['q'] : 0);
if (isset($_GET['q']))
    $item = $_GET['q'];
echo ($item);

$result = "select
(case 
        WHEN  t1.U_Attachments is null  then 'N' else t1.U_Attachments
END) [attachements_issues]
from [dbo].[@QUALITY] t0
inner join [dbo].[@QUAL_ATTACH] t1 on t1.Code = t0.Code
left join oitm t2 on t2.ItemCode = t0.U_itemcode
left join oitb t3 on t3.ItmsGrpCod = t2.ItmsGrpCod
where t0.code='$item'";
$getResults = $conn->prepare($result);
$getResults->execute();
$file_results = $getResults->fetchAll(PDO::FETCH_BOTH);

foreach ($file_results as $fname) {
    $filename = json_encode($fname[0]);
}
echo ($filename);

//Removing backslash
$str = str_replace('\\', '/', $filename);
echo ($str);

$str = str_replace('//', '/', $str);
echo ($str);;
//$file = new SplFileInfo($str);
//$file = new SplFileInfo($str);#

//$extension  = $file->getExtension();
//echo($extension); 


function data_uri($file, $mime)
{
    $contents = file_get_contents($file);
    $base64 = base64_encode($contents);
    return ('data:' . $mime . ';base64,' . $base64);
}
$ext = pathinfo($str, PATHINFO_EXTENSION);
//echo ($ext);
$file_parts = pathinfo($str);
//echo ($file_parts['extension']);
$x = $file_parts['extension'];
echo ("<br>");
//echo ($x);
$x = str_replace('"', '', $x);
echo ("<br>");
//echo ($x);
echo ("<br>");
//echo($str);
$str = str_replace('"', '', $str);
//echo($str);
switch($x)
{
case 'jpg':

    ?>
        <img style='height:600px; width:600px;' src="<?php echo data_uri($str, 'image/jpg'); ?>"> 
        <?php
break;
case 'docx':
break;
}
?>