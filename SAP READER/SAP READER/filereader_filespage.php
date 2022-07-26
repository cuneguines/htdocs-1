<?php
    include './php_constants.php';
    include './php_functions.php';
    include './filereader_functions.php';

    /////////////
    // NEEDS TO BE SET HOW MANY DIRECTORIES DEEP FROM LIVETRACKER_1_x_x root is the filereader placed
    $dir_depth = 0;
    $dir_prefix = generate_cache_dir_prefix($dir_depth);
    ////////////


    if(isset($_GET['itm'])){
        echo "<h1>DO NOT CLOSE WINDOW BEFORE CLICKING CLOSE ATTACHMENTS</h1>";
        get_attachments_item_code($_GET['itm'],$dir_prefix);
        $pass = "locationhref='./filereader_filespage.php?DEL=".$_GET['itm']."'";
        echo "<br><br><br><form action='./filereader_filespage.php' method='get'><button style = 'height:100px; width:500px; font-size:5vh;' name='DEL' value='".$_GET['itm']."'>CLOSE ATTACHMENTS</button></form>";
    
    }
    elseif(isset($_GET['so'])){
        echo "<h1>DO NOT CLOSE WINDOW BEFORE CLICKING CLOSE ATTACHMENTS</h1>";
        get_attachments_sales_order($_GET['so'],$dir_prefix);
        $pass = "locationhref='./filereader_filespage.php?DEL=".$_GET['so']."'";
        echo "<br><br>";
        echo "<form action='./filereader_filespage.php' method='get'><button name='DEL' style = 'height:100px; width:500px; font-size:5vh;' value='".$_GET['so']."'>CLOSE ATTACHMENTS</button></form>";
    }
    
    elseif(isset($_GET['DEL'])){
        remove_item_code_attachment_directory($_GET['DEL'],$dir_prefix);
        echo "<h1>IT IS NOW SAFE TO CLOSE THIS WINDOW<h1>";
    }
    else{
        echo "INCORRECT POST VARIABLE (CODE ERROR)";
    }
?>