<?php 
     
    function array_sort($array){sort($array); return $array;}

    function generate_filter_options($table, $field)
    {
        foreach(array_sort(array_unique(array_column($table, $field))) as $element)
        {
            echo "<option value = '".str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $element))."'>".($element)."</option>";
        }
    }

    function generate_filter_options_unp($table, $field)
    {
        foreach(array_sort(array_unique(array_column($table, $field))) as $element)
        {
            echo "<option value = '".$element."'>".($element)."</option>";
        }
    }

    function generate_cache_dir_prefix($depth){
        if($depth == 0){return '.';}
        
        $str = "..";
        for($i = 1 ; $i < $depth ; $i++){
            $str .= '/..';
        }
        return $str;
    }
?>
<?php
    // ACCEPS A DATABSE CONNECTION, QUERY AND RETURN TYPE AND RETURNS DATA ACCORDING TO RETURN TYPE  
    function get_sap_data($connection, $sql_query, $rtype){
        $getResults = $connection->prepare($sql_query);                                  
        $getResults->execute();

        switch ($rtype){
            case 0: return $getResults->fetchAll(PDO::FETCH_BOTH);
            case 1: return $getResults->fetchAll(PDO::FETCH_NUM)[0][0];
            case 2: return $getResults->fetchAll(PDO::FETCH_ASSOC)[0];
            case 3: return $getResults->fetchALL(PDO::FETCH_NUM);
        }
    }
?>