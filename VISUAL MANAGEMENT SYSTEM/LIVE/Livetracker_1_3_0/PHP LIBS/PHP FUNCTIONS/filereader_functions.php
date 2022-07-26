<?php    
    // GIVEN AN ITEM CODE, WILL SEARCH THE SAP DATABSE TO CHECK IF ATTACHMENTS EXIST FOR PARTICULAR ITEM
    // IF ATTACHMENTS EXIST IT WILL PULL THEM FROM THE SAP SERVER AND STORE THEM IN LOCAL CACHE AND ECHO THEM INSIDE WHATEVER CONTAINER THE FUNCTION IS CALLED FROM
    function get_attachments_item_code($itemcode,$depth){
        include '../../SQL CONNECTIONS/conn.php';

        // IF A FOLDER DOES NOT EXIST OF CACHED ITEMS FOR ITEM CODE A FOLDER IS CREATED IN ./CACHE WITH THE ITEM CODE AS NAME
        if(!file_exists("$depth/CACHED_ATTACHMENTS/$itemcode")){
            create_item_code_attachment_directory($itemcode,$depth);
        }

        // FIND IF AN ITEM HAS ATTACHMEENTS IF NOT RETURN
        $get_file_names = "SELECT t0.ItemCode, t0.Attachment ,t0.AtcEntry, t2.trgtPath, t2.FileName, t2.FileExt from oitm t0 LEFT join atc1 t2 on t0.AtcEntry=t2.AbsEntry WHERE t0.ItemCode = '$itemcode' AND t2.AbsEntry IS NOT NULL";
        $file_names_data = get_sap_data($conn,$get_file_names,DEFAULT_DATA);
        if(!$file_names_data){return;}

        // CONVERT FORMAT OF SQL QUERY TO THAT OF get_attachments_item_code WHERE EACH DIRECTORY IS IN A SINGLE STRING SEPARATED BY A SEMICOLON
        $filenames = "";
        foreach($file_names_data as $fname){
            $filenames.=$fname["trgtPath"]."\\".$fname["FileName"].".".$fname["FileExt"].";";

        }
        
        // SPLIT FILE NAMES IN STRING BY SEMICOLON TO ARRAY (SQL STORES MULTIPLE FILE DIRECTORIES IN SINGLE STRING IF THERE IS MORE THAN ONE ATTACHMENT)
        $file_names = explode(';',$filenames);

        // LOOP THROUGH FILES GETTING FROM SERVER AND PUTTING INTO CACHE SKIPPPING NULL ENTIRES
        // IF THE FILE TYPE IS NOT AN IMAGE ADD TO LIST OF UNDIPLAYABLE FILES OTHERWISE ECHO IMAGE WITH SRC EQUAL TO THE LOCATION OF THE FILE IN CAHCE
        $undisplayable_files = array();
        foreach($file_names as $name){
            //echo $name;
            if($name == ""){break;}
            $file_details = pathinfo($name);
            $file = file_get_contents($name);
            file_put_contents("$depth/CACHED_ATTACHMENTS/$itemcode/".$file_details["filename"].".".$file_details["extension"],$file);
            if(!in_array($file_details["extension"],array('jpg','png','svg','PNG','SVG','JPG'))){
                array_push($undisplayable_files,"$depth/CACHED_ATTACHMENTS/$itemcode/".$file_details["filename"].".".$file_details["extension"]);
            }
            else{
                echo "<img style = 'height:600px; width:600px;' src = '$depth/CACHED_ATTACHMENTS/$itemcode/".$file_details["filename"].".".$file_details["extension"]."'>";
            }
        }

        // ECHO NUMBER OF AND LIST OF UNDISPLAYABLE FILES
        echo "<br><br>Files unable to display ". sizeof($undisplayable_files)."<br>";
        foreach($undisplayable_files as $fname){
            $name = pathinfo($fname)["filename"].".".pathinfo($fname)["extension"];
            echo $name." <a href='$fname' download='$name'>Download</a><br>";;
        };
    }

    // GIVEN AN SALES ORDER, WILL SEARCH THE SAP DATABSE TO CHECK IF ATTACHMENTS EXIST FOR PARTICULAR SALES ORDER
    // IF ATTACHMENTS EXIST IT WILL PULL THEM FROM THE SAP SERVER AND STORE THEM IN LOCAL CACHE AND ECHO THEM INSIDE WHATEVER CONTAINER THE FUNCTION IS CALLED FROM
    function get_attachments_sales_order($sales_order,$depth){
        include '../../SQL CONNECTIONS/conn.php';

        // IF A FOLDER DOES NOT EXIST OF CACHED ITEMS FOR SALES ORDER A FOLDER IS CREATED IN ./CACHE WITH THE ITEM CODE AS NAME
        if(!file_exists("$depth/CACHED_ATTACHMENTS/$sales_order")){
            create_item_code_attachment_directory($sales_order,$depth);
        }

        // FIND IF AN ITEM HAS ATTACHMEENTS IF NOT RETURN
        $get_file_names = "SELECT t0.DocNum , t2.trgtPath, t2.FileName, t2.FileExt, t2.AbsEntry from ORDR t0 LEFT join atc1 t2 on t0.AtcEntry=t2.AbsEntry WHERE t0.DocNum LIKE '$sales_order' AND t2.AbsEntry IS NOT NULL";
        $file_names_data = get_sap_data($conn,$get_file_names,DEFAULT_DATA);
        if(!$file_names_data){return;}

        // CONVERT FORMAT OF SQL QUERY TO THAT OF get_attachments_item_code WHERE EACH DIRECTORY IS IN A SINGLE STRING SEPARATED BY A SEMICOLON
        $filenames = "";
        foreach($file_names_data as $fname){
            $filenames.=$fname["trgtPath"]."\\".$fname["FileName"].".".$fname["FileExt"].";";

        }

        // SPLIT FILE NAMES IN STRING BY SEMICOLON TO ARRAY (SQL STORES MULTIPLE FILE DIRECTORIES IN SINGLE STRING IF THERE IS MORE THAN ONE ATTACHMENT)
        $file_names = explode(';',$filenames);

        // LOOP THROUGH FILES GETTING FROM SERVER AND PUTTING INTO CACHE SKIPPPING NULL ENTIRES
        // IF THE FILE TYPE IS NOT AN IMAGE ADD TO LIST OF UNDIPLAYABLE FILES OTHERWISE ECHO IMAGE WITH SRC EQUAL TO THE LOCATION OF THE FILE IN CAHCE
        $undisplayable_files = array();
        foreach($file_names as $name){
            //echo $name;
            if($name == ""){break;}
            $file_details = pathinfo($name);
            $file = file_get_contents($name);
            file_put_contents("$depth/CACHED_ATTACHMENTS/$sales_order/".$file_details["filename"].".".$file_details["extension"],$file);
            if(!in_array($file_details["extension"],array('jpg','png','svg','PNG','SVG','JPG'))){
                array_push($undisplayable_files,"$depth/CACHED_ATTACHMENTS/$sales_order/".$file_details["filename"].".".$file_details["extension"]);
            }
            else{
                echo "<img style = 'height:300px; width:300px;' src = '$depth/CACHED_ATTACHMENTS/$sales_order/".$file_details["filename"].".".$file_details["extension"]."'>";
            }
        }

        // ECHO NUMBER OF AND LIST OF UNDISPLAYABLE FILES
        echo "<br><br>Files unable to display ". sizeof($undisplayable_files)."<br>";
        foreach($undisplayable_files as $fname){
            $name = pathinfo($fname)["filename"].".".pathinfo($fname)["extension"];
            echo $name." <a href='$fname' download='$name'>Download</a><br>";;
        };
    }

    function get_attachments_purchase_order($purchase_order,$depth){
        include '../../SQL CONNECTIONS/conn.php';

        // IF A FOLDER DOES NOT EXIST OF CACHED ITEMS FOR SALES ORDER A FOLDER IS CREATED IN ./CACHE WITH THE ITEM CODE AS NAME
        if(!file_exists("$depth/CACHED_ATTACHMENTS/$purchase_order")){
            create_item_code_attachment_directory($purchase_order,$depth);
        }

        // FIND IF AN ITEM HAS ATTACHMEENTS IF NOT RETURN
        $get_file_names = "SELECT t0.DocNum , t2.trgtPath, t2.FileName, t2.FileExt, t2.AbsEntry from OPOR t0 LEFT join atc1 t2 on t0.AtcEntry=t2.AbsEntry WHERE t0.DocNum LIKE '$purchase_order' AND t2.AbsEntry IS NOT NULL";
        $file_names_data = get_sap_data($conn,$get_file_names,DEFAULT_DATA);
        if(!$file_names_data){return;}

        // CONVERT FORMAT OF SQL QUERY TO THAT OF get_attachments_item_code WHERE EACH DIRECTORY IS IN A SINGLE STRING SEPARATED BY A SEMICOLON
        $filenames = "";
        foreach($file_names_data as $fname){
            $filenames.=$fname["trgtPath"]."\\".$fname["FileName"].".".$fname["FileExt"].";";

        }

        // SPLIT FILE NAMES IN STRING BY SEMICOLON TO ARRAY (SQL STORES MULTIPLE FILE DIRECTORIES IN SINGLE STRING IF THERE IS MORE THAN ONE ATTACHMENT)
        $file_names = explode(';',$filenames);

        // LOOP THROUGH FILES GETTING FROM SERVER AND PUTTING INTO CACHE SKIPPPING NULL ENTIRES
        // IF THE FILE TYPE IS NOT AN IMAGE ADD TO LIST OF UNDIPLAYABLE FILES OTHERWISE ECHO IMAGE WITH SRC EQUAL TO THE LOCATION OF THE FILE IN CAHCE
        $undisplayable_files = array();
        foreach($file_names as $name){
            //echo $name;
            if($name == ""){break;}
            $file_details = pathinfo($name);
            $file = file_get_contents($name);
            file_put_contents("$depth/CACHED_ATTACHMENTS/$purchase_order/".$file_details["filename"].".".$file_details["extension"],$file);
            if(!in_array($file_details["extension"],array('jpg','png','svg','PNG','SVG','JPG'))){
                array_push($undisplayable_files,"$depth/CACHED_ATTACHMENTS/$purchase_order/".$file_details["filename"].".".$file_details["extension"]);
            }
            else{
                echo "<img style = 'height:300px; width:300px;' src = '$depth/CACHED_ATTACHMENTS/$purchase_order/".$file_details["filename"].".".$file_details["extension"]."'>";
            }
        }

        // ECHO NUMBER OF AND LIST OF UNDISPLAYABLE FILES
        echo "<br><br>Files unable to display ". sizeof($undisplayable_files)."<br>";
        foreach($undisplayable_files as $fname){
            $name = pathinfo($fname)["filename"].".".pathinfo($fname)["extension"];
            echo $name." <a href='$fname' download='$name'>Download</a><br>";
        };
    }

    function create_item_code_attachment_directory($item_code,$depth){
        mkdir("$depth/CACHED_ATTACHMENTS/$item_code/",(string)$item_code, true);
    }
    function remove_item_code_attachment_directory($item_code,$depth) {
        array_map('unlink', glob("$depth/CACHED_ATTACHMENTS/$item_code/*.*"));
        rmdir("$depth/CACHED_ATTACHMENTS/$item_code");
    }
?>
