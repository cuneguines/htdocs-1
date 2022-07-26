<?php
    // READ IN LIBS
    require '../../../PHP LIBS/phpspreadsheets/vendor/autoload.php';
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
    include '../../../PHP LIBS/PHP FUNCTIONS/phpspreadsheets_lookup_data.php';
?>
<?php
    // SECURITY
    // IF PASSWORD IS SUBMITTED AND CORRECT ALLOW TO CONTINUE
    // IF PASSWORD IS SUBMITTED AND INCORRECT REDIVERT TO LOGIN PAGE WITH ERROR MESSAGE
    // IF RELOAD DATA OPTION IS CLICKED REDIVERT TO LOGIN PAGE (ABOVE WILL STILL BE EXECUTED) AND ASK FOR PASSWORD AGAIN
    // OTHERWISE REDIVERT TO LOGIN PAGE
    session_start();
    $hash = "$2y$10$9i0l3Vv59STI5.Gj5efkP.pUQ3YL/498shkn6au3MOPwZteZMBNFm";
    if(isset($_POST['password']) && password_verify(isset($_POST['password']) ? $_POST['password'] : '', $hash)){
        $_SESSION['logged_in'] = 1;
    }
    elseif(isset($_POST['password']) && !password_verify(isset($_POST['password'])? $_POST['password'] : '', $hash)){
        $_SESSION['logged_in'] = 0;
        header("Location:enter_password.php?message=Access Denied");
    }
    else{
        $_SESSION['logged_in'] = 0;
        header("Location:enter_password.php?message=Access Denied");
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <!-- INITALISATION AND META STUFF -->
        <title>TABLE LAYOUT</title>
        <meta name = "viewpport" content = "width=device-width, initial-scale = 1">

        <!-- EXTERNAL JS DEPNDENCIES -->
        <script type = "text/javascript" src = "../../../JS LIBS/THIRD PARTY/jquery-3.4.1.js"></script>				
        <script type = "text/javascript" src = "../../../JS LIBS/THIRD PARTY/jquery.tablesorter.js"></script>
        <script type = "text/javascript" src = "../../../JS LIBS/THIRD PARTY/jquery.tablesorter.widgets.js"></script>

        <!-- LOCAL JS DEPENDENCIES -->
        <script type = "text/javascript" src = "../../../JS LIBS/LOCAL/JS_filters.js"></script>
        <script type = "text/javascript" src = "../../../JS LIBS/LOCAL/JS_search_table.js"></script>
		<script type = "text/javascript" src = "./JS_table_to_excel.js"></script>

        <!-- STYLING -->
        <link href='../../../CSS/LT_STYLE.css' rel='stylesheet' type='text/css'>
        <link rel = "stylesheet" href = "../../../css/theme.blackice.min.css">
        <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>
        
        <!-- PHP DEPENDENCIES -->
        <?php include '../../../PHP LIBS/PHP FUNCTIONS/php_functions.php'; ?>
        <?php
            // LOAD SHEET FROM CACHE AND SET SHEET INDEX (ONLY ONE FOR THIS PAGE) + DEFINE FIRST ROW OF SPREADSHEET WITH DATA
            $spreadsheet = $reader->load('C://VMS_MASTER_DATA/HR_EMP_DATA/EMP_STATIC_DATA/EMPLOYEES.xlsx');
            $spreadsheet->setActiveSheetIndex(0);
            $row = 2;
        ?>

        <!-- TABLESORTER INITALISATION -->
        <script>
            $(function() {
                $(".sortable").tablesorter({
                    theme : "blackice",
                    dateFormat : "ddmmyyyy",
                    headers : { 6: {sorter: false} }
                });
            });
        </script>
    </head>