<?php
session_start();
 
$message = ''; 


  if (isset($_FILES['uploadedFile']) && $_FILES['uploadedFile']['error'] === UPLOAD_ERR_OK)
  {
    // get details of the uploaded file
    $fileTmpPath = $_FILES['uploadedFile']['tmp_name'];
    $fileName = $_FILES['uploadedFile']['name'];
    $fileSize = $_FILES['uploadedFile']['size'];
    $fileType = $_FILES['uploadedFile']['type'];
    $fileNameCmps = explode(".", $fileName);
    $fileExtension = strtolower(end($fileNameCmps));
 
    // sanitize file-name
    $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
 echo ($fileName);
    // check if file has one of the following extensions
    $allowedfileExtensions = array('jpg', 'gif', 'png', 'zip', 'txt', 'xls', 'doc','docx');
 
    if (in_array($fileExtension, $allowedfileExtensions))
    {
      // directory in which the uploaded file will be moved
      $uploadFileDir = './uploaded_files/';
      $dest_path = $uploadFileDir . $fileName;
 echo($uploadFileDir);
      if(move_uploaded_file($fileTmpPath, $dest_path)) 
      {
        $message ='File is successfully uploaded.';
      }
      else
      {
        $message = 'There was some error moving the file to upload directory. Please make sure the upload directory is writable by web server.';
      }
    }
    else
    {
      $message = 'Upload failed. Allowed file types: ' . implode(',', $allowedfileExtensions);
    }
  }
  else
  {
    $message = 'There is some error in the file upload. Please check the following error.<br>';
    $message .= 'Error:' . $_FILES['uploadedFile']['error'];
  }

$_SESSION['message'] = $message;
//header("Location: index.php");
$headers = array(
        "Authorization: Bearer " . $token, 
        "Host: graph.microsoft.com",
        "Content-Type: application/json",
        "Content-Length: 0",
    );

    $postfile = curl_init('https://kentstainlesswex.sharepoint.com/sites/Non_Conformance_Data/Shared%20Documents' . $filename . ':/content'); 
    curl_setopt($postfile, CURLOPT_CUSTOMREQUEST, 'PUT');
    curl_setopt($postfile, CURLOPT_HTTPHEADER, $headers); 
    curl_setopt($postfile, CURLOPT_FOLLOWLOCATION, 1); 
    $result = curl_exec($postfile); 
    curl_close($postfile); 

function file_force_contents( $fullPath, $contents, $flags = 0 ){
    $parts = explode( '/', $fullPath );
    array_pop( $parts );
    $dir = implode( '/', $parts );
   
    if( !is_dir( $dir ) )
        mkdir( $dir, 0777, true );
   
    file_put_contents( $fullPath, $contents, $flags );
}

file_force_contents( 'https://kentstainlesswex.sharepoint.com/sites/Non_Conformance_Data/Shared%20Documents', 'message', LOCK_EX );
 // $filename = $_FILES['file']['name'];
 if (isset($_FILES['uploadedFile']) && $_FILES['uploadedFile']['error'] === UPLOAD_ERR_OK)
 {
   // get details of the uploaded file
   $fileTmpPath = $_FILES['uploadedFile']['tmp_name'];
   $fileName = $_FILES['uploadedFile']['name'];
   $fileSize = $_FILES['uploadedFile']['size'];
   $fileType = $_FILES['uploadedFile']['type'];
   $fileNameCmps = explode(".", $fileName);
   $fileExtension = strtolower(end($fileNameCmps));

   // sanitize file-name
   $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
echo ($fileName);
    $headers = array(
        "Authorization: Bearer " . $token, 
        "Host: graph.microsoft.com",
        "Content-Type: application/json",
        "Content-Length: 0",
    );

    $postfile = curl_init('https://kentstainlesswex.sharepoint.com/sites/Non_Conformance_Data/Shared%20Documents' . $fileName . ':/content'); 
    curl_setopt($postfile, CURLOPT_CUSTOMREQUEST, 'PUT');
    curl_setopt($postfile, CURLOPT_HTTPHEADER, $headers); 
    curl_setopt($postfile, CURLOPT_FOLLOWLOCATION, 1); 
    $result = curl_exec($postfile); 
    curl_close($postfile); 
  }
  try {
    $client = new SPOClient($url);
    $client->signIn($username,$password);
    echo 'You have authenticated successfully\n';
}
catch (Exception $e) {
    echo 'Authentication failed: ',  $e->getMessage(), "\n";
}
?>