<?php 
include 'local-assets/controller/autoloader.php'; 
include 'local-assets/model/view/class.usersview.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="local-assets/controller/js/controller_functions.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
   
 
 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<style>
    body {
        min-height: 170vh;
    }
    .col-sm-6
    {
        width:42%;
        
    }
    .col-md-6
    {
        width:35%;
    }
    
    .box {
        position: relative;
        margin: 0 auto;
        top: 150px;
        width: 800px;
        height: 900px;
        background-color: transparent;
        padding-bottom: 80px;
        border: solid black 0px;
        box-shadow: 0 1px 6px 0 rgba(38, 39, 43, 0.3);
        border-radius: 20px;
    }
    .title {
        position: relative;
        top: 20px;
        text-align: center;
        font-size: 30px;
        color: green;
    }
    .row {
        position: relative;
        left: 40px;
    }
    .label {
        position: relative;
        color: green;
        font-size: 18px;
        top: 0;
        margin-left:-10px;
    }
    .value {
        position: relative;
        font-size: 15px;
        top: 0;
        margin-top: 10px;
        margin-left:0px;
    }
    .imgcontainer {
        text-align: center;
        margin: 24px 0 12px 0;
        top: 15px;
    }
    img.avatar {
        width: 20%;
        border-radius: 50%;
    }
    input[type=text] {
        width: 80%;
        padding-top: 10px;
        padding-bottom: 10px;
        padding-left: 0px;
        margin: 8px 0;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        pointer-events:none;
    }
}
</style>


<body>
                <!-- CONTENT AREA -->
                <!--  BEGIN CONTENT AREA  -->

    <div class="box" id="myBox">
        <div class="title">
            Your Profile
        </div>
        <div class="imgcontainer">
            <img src="img_avatar2.png" alt="Avatar" class="avatar">
        </div>


        <div class="container">
         <div class="row" style="top:100px;">
            <div class="col-md-6 col-sm-6">
                <div class="label">
                    First Name
                </div>
                <input type="text" class="value" value=" <?php
                        $userObj = new UsersView();
                        $userObj->getUserInfo('1');
                        //echo $userArray[0]['cents_user_firstname'];
                        echo $userObj->getFirstName();
                        ?>">

            </div>
            <div class="col-sm-6 col-md-6">
                <div class="label">
                    Last Name
                </div>

                <input type="text" syle="text-align:left" class="value" value=" <?php

                    echo $userObj->getSurName();
                    ?>">


            </div>
        </div>
</div>



<div class="container">
        <div class="row" style="top:120px;">
            <div class="col-sm-6 col-md-6">
                <div class="label">
                   Address
                </div>
                <input type="text" class="value" value=" <?php
                                    
                                    //echo $userArray[0]['cents_user_firstname'];
                                    echo $userObj->getAddressCounty();
                                        ?>">

            </div>

                <div class="col-sm-6 col-md-6">
                <div class="label">
                    Post Code
                </div>

                <input type="text" syle="text-align:left" class="value" value="<?php

                                echo $userObj->getAddressPostCode();
                                        ?>">


            </div>
        </div>
</div>
    
    
    
        


<div class="container">

        <div class="row" style="top:140px;">
            <div class="col-sm-6 col-md-6">
                <div class="label">
                    Email Id
                </div>
                <input type="text" class="value" value="<?php
                                   
                                    echo $userObj->getUserEmail();
                                        ?>">

            </div>

                <div class="col-sm-6 col-md-6">
                <div class="label">
                    Phone no.
                </div>

                <input type="text" class="value" value="<?php
                                    
                                    echo $userObj->getPhone();
                                        ?>">


            </div>
        </div>
</div>





       



    
    
    
    
    
    
    
    
    
    </div>


    </body>
   


     
 

</html>