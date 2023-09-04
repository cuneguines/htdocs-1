<?php
    session_start();
    $hash = "$2y$10$9i0l3Vv59STI5.Gj5efkP.pUQ3YL/498shkn6au3MOPwZteZMBNFm";
    // IF PAGE IS ACCESSED BY LOGIN SCREEN AND PASSWORD IS CORRECT ALLOW TO CONTINUE
    if(isset($_POST['password']) && password_verify(isset($_POST['password'])? $_POST['password'] : '', $hash)){
        $_SESSION['logged_in'] = 1;
    }
    // IF PAGE IS ACCESSED BY LOGIN SCREEN AND PASSWORD IS INCORRECT REDIRECT TO LOGIN WITH ERROR MESSAGE
    elseif(isset($_POST['password']) && !password_verify(isset($_POST['password'])? $_POST['password'] : '', $hash)){
        $_SESSION['logged_in'] = 0;
        header("Location:enter_password.php?message=Access Denied");
    }
    // IF PAGES IS ACCESSED DIRECTLY (SKIPPING LOGIN OR OTHERWISE) REDIRECT WITH ERROR MESSAGE
    else{
        $_SESSION['logged_in'] = 0;
        header("Location:enter_password.php?message=Access Denied");
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Password Protected</title>
        <link rel = "stylesheet" href = "../../../css/LT_style.css">
        <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>
    </head>
    <body>
        <div id = "background">
            <div style = "width:30%; height:auto; position:relative; vertical-align:top; top:20%; left: 35%;">
                <?php //$inputFileNames = scandir('C://VMS_MASTER_DATA/HR_EMP_DATA/CLOCKING/', SCANDIR_SORT_NONE); ?>
                <?php
                    function scan_dir($dir) {
                        $ignored = array('.', '..', '.svn', '.htaccess');

                        $files = array();    
                        foreach (scandir($dir) as $file) {
                            if (in_array($file, $ignored)) continue;
                            $files[$file] = filemtime($dir . '/' . $file);
                        }

                        arsort($files);
                        $files = array_keys($files);

                        return ($files) ? $files : false;
                    }
                ?>
                <?php $inputFileNames = scan_dir('./CACHE/'); ?>
                <?php foreach($inputFileNames as $fname) : ?>
                    <form method = "POST" action = "./BASE_staff_clocking.php"><input type = "submit" name = "month" class = "rounded brred btext medium" style = "width:250px; height:40px; margin-bottom:10px; margin-left:5px; margin-right:5px;" value = "<?=$fname?>" /></form>
                <?php endforeach; ?>
                
            </div>
        </div>
    </body>
</html>