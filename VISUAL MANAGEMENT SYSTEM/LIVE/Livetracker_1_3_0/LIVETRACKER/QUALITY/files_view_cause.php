
	


<?php
//echo json_encode($_POST);
 /* $item=(!empty($_GET['q'])? $_GET['q'] : 0);
if(isset($_GET['q']))
$item=$_GET['q'];
echo($item);

$result="select
case when isnull(t0.U_root_cause_analysis,'N') like 'NA' then 'N' else isnull(t0.U_root_cause_analysis,'N') end [attachments_cause_analysis]

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
        {
         ?> <div style="height:600px;width:600px;float:left;overflow-y:scroll;border:1px solid #666CCC ;"><?php
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
 */

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
function read_doc_file($filename) {
    if(file_exists($filename))
   {
       if(($fh = fopen($filename, 'r')) !== false ) 
       {
          $headers = fread($fh, 0xA00);

          // 1 = (ord(n)*1) ; Document has from 0 to 255 characters
          $n1 = ( ord($headers[0x21C]) - 1 );

          // 1 = ((ord(n)-8)*256) ; Document has from 256 to 63743 characters
          $n2 = ( ( ord($headers[0x21D]) - 8 ) * 256 );

          // 1 = ((ord(n)*256)*256) ; Document has from 63744 to 16775423 characters
          $n3 = ( ( ord($headers[0x21E]) * 256 ) * 256 );

          // 1 = (((ord(n)*256)*256)*256) ; Document has from 16775424 to 4294965504 characters
          $n4 = ( ( ( ord($headers[0x21F]) * 256 ) * 256 ) * 256 );

          // Total length of text in the document
          $textLength = ($n1 + $n2 + $n3 + $n4);

          $extracted_plaintext = fread($fh, $textLength);

          // simple print character stream without new lines
          //echo $extracted_plaintext;

          // if you want to see your paragraphs in a new line, do this
          return nl2br($extracted_plaintext);
          // need more spacing after each paragraph use another nl2br
       }
   }   
   }
/* $result="select attachments 

from ms_qual_log t0
where ID=23";
$getResults = $conn->prepare($result);
$getResults->execute();
$file_results = $getResults->fetchAll(PDO::FETCH_BOTH);

foreach($file_results as $fname)
{
$filename=json_encode($fname[0]);
//echo($filename);
} */

/*$isFolder = is_dir("\\\\kptsv01\groups");
var_dump($isFolder); 
$str='\\kptsv01\groups\Daily Meetings\NCRs\NCR 234456\Rootcause and Corrective action.docx';
echo($str);
//var_dump($file_results[0]);
$content = read_file_docx($str);
if ($content !== false) {
    
    //$content = '<p>' . str_replace("\n", "</p><p>", $content) . '</p>';
       echo ($content);
   } else {
   echo 'Couldn\'t the file. Please check that file.';
  } */
 
/* $path = '\\\\groups(\\kptsv01)(H:)\\Daily Meetings'; 
$handle = fopen('test.txt', 'r');
if($handle){ */
   /*  while (!feof($handle)){
        $buffer = fgets($handle);
        echo $buffer."<br />";
    }
} */
//$file=fopen(file://F:/eventscript.txt', "r")
/* $file=fopen('file://kptsv01/groups/test.txt', 'r'); 
if($file){
    while (!feof($handle)){
        $buffer = fgets($handle);
        echo $buffer."<br />";
    }
}

if($fh=opendir('\\\\kptsv01\\groups\\Daily Meetings\\NCRs')) {
  while (false !== ($fi =readdir($fh))) {
    echo "$fi\n";
  }
} */ 

// $WshShell = new COM("WScript.Shell");
// $oExec = $WshShell->Run("notepad.exe", 7, false);



if($fh=opendir('\\\\kptsv01\\groups\\Daily Meetings\\NCRs')) {
  while (false !== ($fi =readdir($fh))) {
    echo "$fi\n";
  }
}
$file1=read_file_docx('\\\\kptsv01\\groups\\Daily Meetings\\NCRs\\NCR 234456\\Root cause and Corrective Document.docx');

echo($file1);


$file1 = "\\\\kptsv01\\groups\\Daily Meetings\\NCRs\\NCR 234456\\Rootcause and Corrective action.docx"; //Let say If I put the file name Bang.png
$file2 = "\\\\kptsv01\\groups\\Daily Meetings\\NCRs\\NCR 234456\\tes.pdf";
//echo "<a href='download1.php?nama=".$file2."'>download</a> "; 



ob_end_clean();
header('Content-Type: application/octet-stream');
header("Content-Transfer-Encoding: Binary"); 
header("Content-disposition: attachment; filename=\"" . basename($file1) . "\""); 
readfile($file1); 
exit();
