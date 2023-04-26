<?php
    // SECURITY
    // IF PASSWORD IS SUBMITTED AND CORRECT ALLOW TO CONTINUE
    // IF PASSWORD IS SUBMITTED AND INCORRECT REDIVERT TO LOGIN PAGE WITH ERROR MESSAGE
    // IF RELOAD DATA OPTION IS CLICKED REDIVERT TO LOGIN PAGE (ABOVE WILL STILL BE EXECUTED) AND ASK FOR PASSWORD AGAIN
    // OTHERWISE REDIVERT TO LOGIN PAGE
    if(!isset($_POST['user']) || !isset($_POST['password'])){
        header("Location:enter_password.php?message=Access Denied");
    }

    $user = isset($_POST['user']) ? $_POST['user'] : "NO_USER";
    $pw = isset($_POST['password']) ? $_POST['password'] : "NO_PASSWORD";
 
    //print($user);
    //print($pw);

    include '../../PHP LIBS/PHP FUNCTIONS/php_functions.php';
    include '../../SQL CONNECTIONS/conn.php';
	$query = "SELECT U_NAME FROM OUSR WHERE USERID = $user";
    $results = get_sap_data($conn, $query, DEFAULT_DATA);
    $name = ($results[0]["U_NAME"]);
    $hash = '$2y$10$BCgIWzB7Z7JLOI23HsXFhu22dj7XWCmUca8gT2rfZpEHA9uzv1tYi';


    // USING USER ID GO TO SQL AND RETURN USER NAME AND PASSWORD OF THAT USER 

    //$passwords = array ("123" => array("name" => "john", "pw" => '$2y$10$zOA09P6Va0krAG2TpzbvaeykDCe/PRKjWLEDQ8P3hyR/1GnTzq4r6'),
                            //"456" => array("name" => "bill", "pw" => '$2y$10$LWSsNX477wnZJSrxfaQaI.192LvqLn7UxaBJepvLEik6dOM/H5xuO'));


    //$username = $passwords[$user]["name"];
    //$u_password = $passwords[$user]["pw"];

  

    //print($user." ".$username." ".$u_password);
    //var_dump(password_hash($pw, null));

    if(password_verify($pw, $hash)){
        $_SESSION['logged_in'] = 1;
    }
    else{
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
        <link rel = "stylesheet" href = "../../css/theme.blackice.min.css">
        <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>

        
    </head>
    <body>
        <div>
            <h1>USER</h1>
            <p><?=$name?></p>
        </div>
    </body>
</html>