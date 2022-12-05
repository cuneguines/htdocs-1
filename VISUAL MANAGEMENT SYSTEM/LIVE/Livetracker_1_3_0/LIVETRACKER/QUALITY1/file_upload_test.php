

<?php
if (isset($_POST['submit']))
{
// From URL to get webpage contents.

$name=$_FILES['file']['name'];
$tmp_name=$_FILES['file']['tmp_name'];
$type=$_FILES['file']['type'];

$url = "https://kentstainlesswex.sharepoint.com/sites/Non_Conformance_Data/Shared%20Documents";
$data=array("file"=>curl_file_create($tmp_name,$type,$name));
// Initialize a CURL session.
$ch = curl_init();
// Return Page contents.
//curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//grab URL and pass it to the variable.
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:multipart/form-data'));

$result = curl_exec($ch);
curl_close($ch);
echo"<pre>";
print_r($result);
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>Multipart Form Data</title>
  </head>
  <body>
    <form method="POST" 
          enctype="multipart/form-data">
     <h4>Browse your file</h4>
       <input type="file" name="file" /> <br><br>
       <input type="submit" name="submit"/>
   </form>
  </body>
</html>

