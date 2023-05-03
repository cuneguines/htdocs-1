<html>
    <title>Password Protected</title>
    <link rel = "stylesheet" href = "../../css/LT_STYLE.css">
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>
    <body>
        <style>
    body {
  background: #555;
  font: 1em/1.25 trebuchet ms, verdana, sans-serif;
  color: #fff;
  height:100vh;
}
</style>
        <div style="margin-top:20%">
            <div style = "width:30%; height:20%; position:relative; vertical-align:top; top:40%; left: 35%; background-color:#ff5c33;">
                <form style = "height:100%;background: linear-gradient(#606062, #28262b); margin:0;" action = "./test.php" method="post">
                    <p style =  "text-transform:uppercase;color:white; font-size:20px; margin-bottom:30px;"><br>Enter Userid & Password :</p>
                    <input style = "font-size:20px; width:30%; height:30%;" type="text" name="user" placeholder = "user"></input>
                    <input style = "font-size:20px; width:30%; height:30%;" type="password" name="password" placeholder = "password"></input>
                    <input style = "font-size:20px; width:20%; height:30%;" type = "submit" value = "submit">
                    <?php 
                        if(isset($_GET['message'])){
                            echo "<br><p style = 'font-family:sans-serif; color:white; font-size:20px;'>".$_GET['message']."</p>";
                        }
                    ?>
            </div>
        </div>
    </body>
</html>