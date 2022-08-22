
<?php include './conn.php' ?>
<?php include './php_constants.php' ?>


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
// The location of the PDF file
// on the server
$filename = "\\Kptsvsp\b1_shr\Attachments\TEST REPORT 2.docx";

// Header content type
//header("Content-type: application/vnd.ms-word");

//header("Content-Length: " . filesize($filename));

// Send the file to the browser.
//readfile($filename);
$get_file_names = "select
t1.U_Attachments

from [dbo].[@QUALITY] t0
inner join [dbo].[@QUAL_ATTACH] t1 on t1.Code = t0.Code
left join oitm t2 on t2.ItemCode = t0.U_itemcode
left join oitb t3 on t3.ItmsGrpCod = t2.ItmsGrpCod";
//$file_names_data = get_sap_data($conn, $get_file_names, DEFAULT_DATA);
//echo (json_encode($file_names_data));
/* if (!$file_names_data) {
    return;
} */

// FORMAT SQL QUERY TO ARRAY OF DIRECTORIES AS STRINGS
/* $filenames = array();

foreach ($file_names_data as $fname) {

    array_push($filenames,  $fname);
    //echo "<img style = 'height:600px; width:600px;' src = '\\Kptsvsp\b1_shr\Attachments\PHOTO-2022-06-21-12-22-16.jpg'>";
} */
//Reading file from the server and displaying it by converting it into Binary file
function data_uri($file, $mime)
{
    $contents = file_get_contents($file);
    $base64 = base64_encode($contents);
    return ('data:' . $mime . ';base64,' . $base64);
}
//$mime_type == "application/pdf"


$filename = "//Kptsvsp/b1_shr/Attachments/TEST REPORT 2.docx"; // or /var/www/html/file.docx


$filenam = "//Kptsvsp/b1_shr/Attachments/TEST REPORT 2.docx";
function data_urii($file, $mime)
{
    $contents = file_get_contents($file);
    $base64 = base64_encode($contents);
    $binary = base64_decode($base64);
    return ('data:' . $mime . ';base64,' . $contents);
}
$contents = file_get_contents($filenam);
$base64 = base64_encode($contents);
$binary = base64_decode($base64);
file_put_contents('mydoc.docx', $binary);
//$file='my.pdf';

// The location of the PDF file
// on the server
$filenam = "//Kptsvsp/b1_shr/Attachments/3650.pdf";
$contents = file_get_contents($filenam);
$base64 = base64_encode($contents);
$binary = base64_decode($base64);
file_put_contents('my.pdf', $binary);
$file = 'my.pdf';
$filenam = "//Kptsvsp/b1_shr/Attachments/TEST REPORT 2.docx";
$contents = file_get_contents($filenam);
//$base64 = base64_encode($contents);
//$binary = base64_decode($base64);
file_put_contents('ppt.docx', $contents);

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
$filename = "//Kptsvsp/b1_shr/Attachments/TEST REPORT 2.docx";
$file_content = "NCR pp.pptx"; // or /var/www/html/file.docx  
//$content = read_file_docx($filename);
$raw_data = base64_encode($file_content);

$binary = base64_decode($raw_data);
file_put_contents('x.pptx', $binary);
?>

</div>
<?php

?>

<iframe style="height:600px; width:600px;border:1px solid #666CCC" title="My PDF" src="my.pdf" frameborder="1" scrolling="auto" height="1100" width="850" ></iframe>
<!-- <iframe style="height:600px; width:600px;border:1px solid #666CCC" title="" src="x.pptx" frameborder="1" scrolling="auto" height="1100" width="850" ></iframe>   -->
<!-- <iframe style="border:1px solid #666CCC" title="My PDF" src="ppt.docx&embedded=true" frameborder="1" scrolling="auto" height="1100" width="850" ></iframe>  --> 


<!-- <iframe style='height:600px; width:600px;' src="<?php echo data_urii('//Kptsvsp/b1_shr/Attachments/TEST REPORT 2.docx', 'application/vnd.openxmlformats-officedocument.wordprocessingml.template'); ?>"></iframe> -->
<img style='height:600px; width:600px;' src="<?php echo data_uri('//Kptsvsp\b1_shr/Attachments/PHOTO-2022-06-21-12-22-16.jpg', 'image/jpg'); ?>">
<?php
//echo "<img style = 'height:600px; width:600px;' src = '$fname"; 
// LOOP THROUGH FILES GETTING FROM SERVER AND PUTTING INTO CACHE SKIPPPING NULL ENTIRE
// IF THE FILE TYPE IS NOT AN IMAGE ADD TO LIST OF UNDIPLAYABLE FILES OTHERWISE ECHO IMAGE WITH SRC EQUAL TO THE LOCATION OF THE FILE IN CAHCE
$undisplayable_files = array();
/* foreach ($filenames as $name) {
    //echo $name;
    if ($name == "") {
        break;
    }
    $file_details = pathinfo($name);
    $file = file_get_contents($name);
    file_put_contents("$depth/CACHED_ATTACHMENTS/$itemcode/" . $file_details["filename"] . "." . $file_details["extension"], $file);
    if (!in_array($file_details["extension"], array('jpg', 'png', 'svg', 'PNG', 'SVG', 'JPG'))) {
        array_push($undisplayable_files, "$depth/CACHED_ATTACHMENTS/$itemcode/" . $file_details["filename"] . "." . $file_details["extension"]);
    } else {
        echo "<img style = 'height:600px; width:600px;' src = '$depth/CACHED_ATTACHMENTS/$itemcode/" . $file_details["filename"] . "." . $file_details["extension"] . "'>";
    }
}
 */
/* function get_sap_data($connection, $sql_query, $rtype)
{
    $getResults = $connection->prepare($sql_query);
    $getResults->execute();
    echo ($rtype);
    switch ($rtype) {
        case 0:
            return $getResults->fetchAll(PDO::FETCH_BOTH);
        case 1:
            return $getResults->fetchAll(PDO::FETCH_NUM)[0][0];
        case 2:
            return $getResults->fetchAll(PDO::FETCH_ASSOC)[0];
        case 3:
            return $getResults->fetchALL(PDO::FETCH_NUM);
    }
} */
?>
<div style="height:600px;width:600px;float:left;overflow-y:scroll;border:1px solid #666CCC"><?php
$content = read_file_docx($filename);
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
$document="//Kptsvsp/b1_shr/Attachments/TEST REPORT WITH PICS.docx";
$paths=readZippedImages( $document );
readZippedImages($document);
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

<div style="height:600px;width:600px;float:left;overflow-y:scroll;border:1px solid #666CCC">
<?php


$document="//Kptsvsp/b1_shr/Attachments/TEST RCA 11.pptx";
$paths=readZippedImages( $document );
readZippedImages($document);
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