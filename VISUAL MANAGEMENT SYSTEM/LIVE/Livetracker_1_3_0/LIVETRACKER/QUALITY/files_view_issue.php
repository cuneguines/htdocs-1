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
<?php
//echo json_encode($_POST);
$item = (!empty($_GET['q']) ? $_GET['q'] : 0);
if (isset($_GET['q']))
    $item = $_GET['q'];
echo ($item);

$result = "select t0.attachments,
(case 
WHEN  t0.attachments ='' then 'N'  else t0.attachments
END) [attachements_issues]
from ms_qual_log t0
where t0.form_type = 'Non Conformance'
and t0.ID=25";



$file="https://kentstainlesswex-my.sharepoint.com/personal/cnixon_kentstainless_com/_layouts/15/Doc.aspx?sourcedoc=%7BEA2E3B33-633B-46AA-A9DB-BB5D3698B61B%7D&file=Root%20cause%20and%20Corrective%20Document_Cuneguines%20Nixon.docx";

    ?>
<a href="https://kentstainlesswex-my.sharepoint.com/personal/cnixon_kentstainless_com/_layouts/15/Doc.aspx?sourcedoc=%7BEA2E3B33-633B-46AA-A9DB-BB5D3698B61B%7D&file=Root%20cause%20and%20Corrective%20Document_Cuneguines%20Nixon.docx">Click</a>
<a href="https://kentstainlesswex-my.sharepoint.com/personal/bcleary_kentstainless_com/Documents/Apps/Microsoft%20Forms/Non%20Conformance%20Log/Question/Process%20Sheet%2044963_Barry%20Cleary.pdf">cliuck</a>
<a href ="https://kentstainlesswex-my.sharepoint.com/personal/bcleary_kentstainless_com/Documents/Apps/Microsoft%20Forms/Non%20Conformance%20Log/Question/20221017_143815_Sean%20O%27Brien.jpg">click me</a>
<a href ="https://kentstainlesswex-my.sharepoint.com/:f:/g/personal/cnixon_kentstainless_com/EmISr9waMW9EoocYQsEWAMIBknQAescMTXTHD9b2bcqeRQ?e=33lrtU">click for files </a>
<a href="https://kentstainlesswex-my.sharepoint.com/personal/cnixon_kentstainless_com/_layouts/15/onedrive.aspx?ga=1&id=%2Fpersonal%2Fcnixon%5Fkentstainless%5Fcom%2FDocuments%2FNCRs%2FNCR%20234456">click here </a>
<?php
$getResults = $conn->prepare($result);
$getResults->execute();
$file_results = $getResults->fetchAll(PDO::FETCH_BOTH);
//print_r($file_results);
function data_uri($file, $mime)
    {
        $contents = file_get_contents($file);
        $base64 = base64_encode($contents);
        return ('data:' . $mime . ';base64,' . $base64);
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
foreach ($file_results as $fname) {
    $filename = json_encode($fname[0]);

echo ($filename);
echo ("<br>");
$string = $filename; 
$str_arr = preg_split ("/\}/", $string); 
//print_r($str_arr);
echo ("<br>");
  foreach ($str_arr as $arr)
  {
   echo ("<br>");
//echo($arr);


$stringParts = explode('link\":\"', $arr);
echo ("<br>");
//print_r($stringParts[1]);
echo ("<br>");
$stringspliagain=explode('\",\"id', $stringParts[1]);
echo ("<br>");
print_r($stringspliagain[0]);
$str = str_replace('\\', '/', $stringspliagain[0]);
echo ($str);
$str = str_replace('//', '/', $str);
echo ($str);
?>
<a href=<?=$str?>>Click me </a>
<a href = "https://kentstainlesswex-my.sharepoint.com/personal/cnixon_kentstainless_com/Documents/Apps/Microsoft%20Forms/Untitled%20form%201/Question/dUBr2Is_Cuneguines%20Nixon.png">click me <a>
<img style='height:400px; width:400px;float:left;margin-left:2%' src="<?php echo data_uri("https://kentstainlesswex-my.sharepoint.com/personal/cnixon_kentstainless_com/Documents/Apps/Microsoft%20Forms/Untitled%20form%201/Question/dUBr2Is_Cuneguines%20Nixon.png", 'image/png'); ?>"> 
    <?php
    $ext = pathinfo($str, PATHINFO_EXTENSION);
    //echo ($ext);
    $file_parts = pathinfo($str);
    //echo ($file_parts['extension']);
    $x = $file_parts['extension'];
    echo($x);
echo ("<br>");


  }


  
  
//Removing backslash
foreach ($stringspliagain as $filename)
{
 echo($filename)   ;
}
echo($stringspliagain[0]);
$str = str_replace('\\', '/', $filename);
//echo ($str);

$str = str_replace('//', '/', $str);
//echo ($str);;
//$file = new SplFileInfo($str);
//$file = new SplFileInfo($str);#

//$extension  = $file->getExtension();
//echo($extension); 



$ext = pathinfo($str, PATHINFO_EXTENSION);
//echo ($ext);
$file_parts = pathinfo($str);
//echo ($file_parts['extension']);
$x = $file_parts['extension'];
//echo ("<br>");
//echo ($x);
$x = str_replace('"', '', $x);
//echo ("<br>");
//echo ($x);
//echo ("<br>");
//echo($str);
$str = str_replace('"', '', $str);
//echo($str);
switch($x)
{
case 'jpg':
case 'JPG':
    
    ?>
        <img style='height:400px; width:400px;float:left;margin-left:2%' src="<?php echo data_uri($str, 'image/jpg'); ?>"> 
        <?php
break;
case 'docx':

break;
case 'msg':
    
    

    header("Content-Type: application/download");
    header("Content-disposition: attachment; filename=\"".$str."\"");
    header("Content-Transfer-Encoding: Binary");
    
    readfile($str);
    exit;
      break;
case 'pptx':
    {
?> <div style="height:600px;width:600px;float:left;overflow-y:scroll;border:1px solid #666CCC ;"><?php
$content = read_file_docx($str);
if ($content !== false) {
    
    $content = '<p>' . str_replace("\n", "</p><p>", $content) . '</p>';
    echo ($content);
} else {
    echo 'Couldn\'t the file. Please check that file.';
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

    printf('<img src="data:image/%s;base64, %s" style=height:400px;width:400px/>', $ext, $data );
    echo("<br>");
    echo("<br>");
    
}
$name = pathinfo($str)["filename"].".".pathinfo($str)["extension"];
echo $name." <a href='$str' download='$name'>Download</a><br>";;
?>

</div>
<?php
        }
    break;
}

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
