<?php include '../../SQL CONNECTIONS/conn.php'; ?>
<?php ?>
<head>
<style>
br {
    display: block;
    
    margin-top:10px; 
    
    
 }
 p
 {
    background-color: lightcyan;
    margin-left:1%;
 }
 </style>
 <?php

//echo json_encode($_POST);
$item=(!empty($_GET['q'])? $_GET['q'] : 0);
if(isset($_GET['q']))
$item=$_GET['q'];
echo($item);

$result="select
(case 

        WHEN t0.U_prev_action_report is null  then 'N' else t0.U_prev_action_report

END) [attachments_preve_action]

from [dbo].[@QUALITY] t0
inner join [dbo].[@QUAL_ATTACH] t1 on t1.Code = t0.Code
left join oitm t2 on t2.ItemCode = t0.U_itemcode
left join oitb t3 on t3.ItmsGrpCod = t2.ItmsGrpCod
where t0.code='$item'"

;
$getResults = $conn->prepare($result);
$getResults->execute();
$file_results = $getResults->fetchAll(PDO::FETCH_BOTH);

foreach($file_results as $fname)
{
$filename=json_encode($fname[0]);
}
echo($filename);
$str = str_replace('\\', '/', $filename);
//echo($str);

$str = str_replace('//', '/', $str);
//echo($str);;
//$file = new SplFileInfo($str);
//$file = new SplFileInfo($str);#

//$extension  = $file->getExtension();
//echo($extension); 
$str = str_replace('"', '', $str);
$ext = pathinfo($str, PATHINFO_EXTENSION);
//echo($ext);
$ext = str_replace('"', '', $ext);
switch($ext)
{
    case 'pptx': 
        echo("cant read");
        break;
    case 'docx':
        {
        ?> <div style="height:600px;width:600px;float:left;overflow-y:scroll;border:1px solid #666CCC"><?php
$content = read_file_docx($str);
if ($content !== false) {
    
    $content = '<p>' . str_replace("\n", "</p><p>", $content) . '</p>';
    echo ($content);
} else {
    echo 'Couldn\'t the file. Please check that file.';
}
function readZippedImages($filename) {
    $paths=[];
    $zip = new ZipArchive;
    if( true === $zip->open( $filename ) ) {
        for( $i=0; $i < $zip->numFiles;$i++ ) {
            $zip_element = $zip->statIndex( $i );
            if( preg_match( "([^\s]+(\.(?i)(jpg|jpeg|png|gif|bmp))$)", $zip_element['name'] ) ) {
                $paths[ $zip_element['name'] ]=base64_encode( $zip->getFromIndex( $i ) );
            }
        }
    }
    $zip->close();
    return $paths;
}
//$document="//Kptsvsp/b1_shr/Attachments/TEST REPORT WITH PICS.docx";
$paths=readZippedImages( $str );
readZippedImages($str);
foreach($paths as $name => $data ){
    $filepath=__DIR__ . '/' . $name;
    $dirpath=pathinfo( $filepath, PATHINFO_DIRNAME );
    $ext=pathinfo( $name, PATHINFO_EXTENSION );
    if( !file_exists( $dirpath ) )mkdir( $dirpath,0777, true );
    if( !file_exists( $filepath ) )file_put_contents( $filepath, base64_decode( $data ) );

    printf('<img src="data:image/%s;base64, %s" style=height:200px;width:200px/>', $ext, $data );
}
?>

</div>
<?php
        }
    break;
}


function read_file_docx($filename)
{
    $striped_content = '';
    $content = '';
    if (!$filename || !file_exists($filename)) return false;
    $zip = zip_open($filename);
    if (!$zip || is_numeric($zip)) return false;
    while ($zip_entry = zip_read($zip)) {
        if (zip_entry_open($zip, $zip_entry) == FALSE) continue;
        if (zip_entry_name($zip_entry) != "word/document.xml") continue;
        $content .= zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
        zip_entry_close($zip_entry);
    } // end while  
    zip_close($zip);
    $content = str_replace('</w:r></w:p></w:tc><w:tc>', " ", $content);
    $content = str_replace('</w:r></w:p>', "\r\n", $content);
    $striped_content = strip_tags($content);
    return $striped_content;
}