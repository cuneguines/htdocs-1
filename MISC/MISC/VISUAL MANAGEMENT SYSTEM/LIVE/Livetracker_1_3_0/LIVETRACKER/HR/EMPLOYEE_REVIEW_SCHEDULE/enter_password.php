<html>
    <title>Password Protected</title>
    <link rel = "stylesheet" href = "../../../css/LT_STYLE.css">
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>
    <body>
        <div id = "background">
            <div style = "width:30%; height:20%; position:relative; vertical-align:top; top:40%; left: 35%; background-color:#ff5c33;">
                <form style = "height:100%; margin:0;" action = "BASE_staff_review_schedule.php" method="post">
                    <p style = "font-family:sans-serif; color:white; font-size:30px; margin-bottom:30px;"><br>Enter Password :</p>
                    <input style = "font-size:30px; width:70%; height:30%;" type="password" name="password"></input>
                    <input style = "font-size:30px; width:20%; height:30%;" type = "submit" value = "submit">
                    <?php 
                        if(isset($_GET['message'])){
                            echo "<br><p style = 'font-family:sans-serif; color:white; font-size:20px;'>".$_GET['message']."</p>";
                        }
                    ?>
            </div>
        </div>
    </body>
</html>