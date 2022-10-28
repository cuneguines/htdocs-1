<?php
// Page to handle the ajax calls to the controller from the controller_function.js file

include '../model/dbhc.php';
include '../model/users.php';
include 'userscontroller.php';

include '../model/dbht.php';
include '../model/references.php';
include 'refcontroller.php';

// Get send data
$uId = (!empty($_POST['uId']) ? $_POST['uId'] : '');
$assignNewProject = (!empty($_POST['assignNewProject']) ? $_POST['assignNewProject'] : '');
$assigneeID = (!empty($_POST['assigneeID']) ? $_POST['assigneeID'] : '');

/* DATETIME for date_created in MySQL */ 
date_default_timezone_set('Europe/Dublin');
$dateCreated = date("Y-m-d H:i:s", time());


        case "registerUser":
            include("../../../common/ASEngine/AS.php");
            // first check the captcha! - then call the botprotection function
            // if(strcasecmp($_SESSION['captcha'], $_POST['captcha']) != 0){

            $userFirstName = (!empty($_POST['firstName']) ? $_POST['firstName'] : '');
            $userSurname = (!empty($_POST['surname']) ? $_POST['surname'] : '');
            $password = (!empty($_POST['password']) ? $_POST['password'] : '');
            $userEmail = (!empty($_POST['email']) ? $_POST['email'] : '');

            $streetAddress = (!empty($_POST['email']) ? $_POST['email'] : '');
            $areaAddress = (!empty($_POST['areaAddress']) ? $_POST['areaAddress'] : '');
            $city = (!empty($_POST['city']) ? $_POST['city'] : '');
            $county = (!empty($_POST['county']) ? $_POST['county'] : '');
            $eirCode = (!empty($_POST['eirCode']) ? $_POST['eirCode'] : '');
            $phoneNo = (!empty($_POST['phoneNo']) ? $_POST['phoneNo'] : '');
            $firstPropertyType = (!empty($_POST['firstPropertyType']) ? $_POST['firstPropertyType'] : '');
            $firstMeterAddress = (!empty($_POST['firstMeterAddress']) ? $_POST['firstMeterAddress'] : '');
            $otherMeterAddresses = (!empty($_POST['otherMeterAddresses']) ? $_POST['otherMeterAddresses'] : '');
            $MPRNS = (!empty($_POST['MPRNS']) ? $_POST['MPRNS'] : '');
            $equipment = (!empty($_POST['equipment']) ? $_POST['equipment'] : '');

            ///going to generate a customer number ->
            $user = new UsersController();
            $customerNo = $user->createCustomerNumber();

            $register->botProtection();
            // then the captcha meets
            $regBotSsum = ASSession::get("bot_first_number") + ASSession::get("bot_second_number");

            // firstly should add email and password to as_users - the username for the platform needs to be generated
            $userData = array("username" => $customerNo, "email" => $userEmail, "password" => $password, 'confirm_password' => $password,   "bot_sum" => $regBotSsum);
            $userData = array('fieldId' => $userData, "userData" => $userData);

            $results = $register->register($userData);
            // Now add user general details to the database


            if ($results["status"] == "error") {
                echo ("Error");
                break;
            }
        
            // see where they added successfully - ideally the AS engine should return a no!
            $password = $register->hashPassword($password);
            $result = $login->select(
                "SELECT user_id FROM `as_users`
                               WHERE `username` = :u AND `password` = :p",
                array(
                    "u" => $customerNo,
                    "p" => $password
                )
            );

            if (count($result) == 1) {
                // THE USER HAS BEEN CREATED FOR ASENGINE
                // session_stop();
                $ASUserID = $result[0]['user_id'];
              
                $result = $user->registerGeneralUser($ASUserID, $customerNo, $userFirstName, $userSurname,  $streetAddress, $areaAddress, $city, $county, $eirCode, $MPRNS, $firstPropertyType, $phoneNo);
                echo($result);

                //Now add the address

                //Any errors - return?

            } else {  // just return wasnt added 
                break;
            }
            // }
            // else {
            //     echo("Please check captcha");
            // }
            break;

        case "checkUserExists":
            // This should probably by in ASAJax.php directly but ...
            //actually going to leave it out of here as a independant file for the moment

            // ASUSERs.php


            break;
        case "bar":
            echo "i is bar";
            break;

        default:
            // This is called when the switch can't do anything.
            break;
    }
}
