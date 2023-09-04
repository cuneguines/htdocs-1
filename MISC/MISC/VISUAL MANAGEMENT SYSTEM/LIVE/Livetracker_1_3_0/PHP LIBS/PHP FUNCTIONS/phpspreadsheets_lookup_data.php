<?php 
    function get_day_difference($date){

        $date_1 = $date;
        $date_2 = time();
        $date_1_s = strtotime($date_1);
        $date_2_s = $date_2;
        $difference = $date_2_s - $date_1_s;
        $days = floor($difference/(24*60*60));
        return($days);
    }

    function add_days_to_date($date, $days){

        $date_s = strtotime($date);
        $new_date_s = $date_s + (24*60*60)*$days;
        $new_date = date('d-m-Y',$new_date_s);
        return($new_date);
    }

    function convert_serial_date($date)	{
        $timestamp = ($date - 25569) * 86400;
        return date("d-m-Y",$timestamp);
    }
    

    
    // READ IN SPREADSHEET THAT CONTAINS THE DESCRIPTIONS NAMES OF ABSENCE ABBREVIATIONS CREATE STANDARD ARRAY TO HOLD DATA AND DEFINE START ROW OF DATA ON THE SPREADSHEET !!!!! (1,2,3) NOT (0,1,2) !!!!!
    $absence_abbreviations_xlsx = $reader->load('C://VMS_MASTER_DATA/HR_EMP_DATA/EMP_STATIC_DATA/ABSENCE_ABBREVIATIONS.xlsx');
    $absence_abbreviations = array();
    $row = 2;
    // PUSH DATA FROM PHPSPREADSHEETS INTO PHP ARRAY FOR CONVENIANCE 
    while($absence_abbreviations_xlsx->getSheet(0)->getCell('A'.$row)->getValue()){
        $absence_abbreviations[(string)$absence_abbreviations_xlsx->getSheet(0)->getCell('A'.$row)->getValue()] = $absence_abbreviations_xlsx->getSheet(0)->getCell('C'.$row)->getValue();
        $row++;
    }

    // READ IN SPREADSHEET THAT CONTAINS THE EMPLOYEE MASTER DATA
    $employees_xlsx = $reader->load('C://VMS_MASTER_DATA/HR_EMP_DATA/EMP_STATIC_DATA/EMPLOYEES.xlsx');
    $full_emp_list = array();
    $row = 2;

    // PUSH DATA FROM PHPSPREADSHEETS INTO PHP ARRAY FOR CONVENIANCE
    while($employees_xlsx->getActiveSheet()->getCell('A'.$row)->getValue() != ''){
        
        // SKIP DEREK(511) AND PAT(510) KENT AND OUTSIDE CONTRACTORS(8XX)
        $emp_id = $employees_xlsx->getSheet(0)->getCell('A'.$row)->getValue();
        if((int)$emp_id == 510 || (int)$emp_id == 511 || (int)$emp_id >= 800){$row++;continue;}

        $full_emp_list[$employees_xlsx->getSheet(0)->getCell('A'.$row)->getValue()] 
            = array(
                "emp_id" =>         $employees_xlsx->getSheet(0)->getCell('A'.$row)->getValue(),
                "emp_name" =>       $employees_xlsx->getSheet(0)->getCell('B'.$row)->getValue(),
                "emp_dept_no" =>    $employees_xlsx->getSheet(0)->getCell('G'.$row)->getValue(),
                "emp_dept_name" =>  $employees_xlsx->getSheet(0)->getCell('G'.$row)->getValue() ? substr($employees_xlsx->getSheet(0)->getCell('G'.$row)->getValue(),3) : "NO DEPARTMENT",
                "emp_supervisor" =>     $employees_xlsx->getSheet(0)->getCell('BG'.$row)->getValue() ? $employees_xlsx->getSheet(0)->getCell('BG'.$row)->getValue() : "NO SUPERVISOR",
            );
        $row++;
    }
    //print_r($full_emp_list);

    // ACCEPTS EMPLOYEE NUMBER AND CHECKS WHEITHER IT IS IN THE MASTER OR NOT
    function check_emp_on_master($emp_no){
        global $full_emp_list;
        return !isset($full_emp_list[$emp_no]) ? 0 : 1;
    }

    function get_emp_name($emp_no){
        global $full_emp_list;
        return $full_emp_list[$emp_no]["emp_name"];
    }

    // ACCEPTS EMPLOYEE NUMBER AND RETURNS THE DEPARTMENT NUMBER (SEARCHES FOR ROW NUMBER OF EMP ID AND USES AS INDEX IN MASTER TO FIND DEPT NUMBER)
    function get_dept_no($emp_no){
        global $full_emp_list;
        return $full_emp_list[$emp_no]["emp_dept_no"];
    }

    // ACCEPTS DEPARTMENT NUMBER AS NUMBER AND RETURNS NAME OF DEPARTMENT (SEARCHES FOR ROW NUMBER OF EMP ID AND USES AS INDEX IN MASTER TO FIND DEPT NAME)
    function get_emp_dept_name($emp_no){
        global $full_emp_list;
        return $full_emp_list[$emp_no]["emp_dept_name"];
    }

    // ACCEPTS DEPARTMENT NUMBER AS NUMBER AND RETURNS NAME OF DEPARTMENT (SEARCHES FOR ROW NUMBER OF EMP ID AND USES AS INDEX IN MASTER TO FIND SUPERVISOR)
    function get_emp_supervisor($emp_no){
        global $full_emp_list;
        return $full_emp_list[$emp_no]["emp_supervisor"];
    }

    // ACCEPS ABSENCE ABBREVIATION AND RETURNS DESCRIPTION OF ABREVIATION (SEARCHES FOR ROW NUMBER FROM ABREVIATION MASTER AND USES AS INDEX IN THE MASTER TO FIND ITS ENGLISH DESCRIPTION COUNTERPART)
    function get_ref_abreviation($abbreviation){
        global $absence_abbreviations;
        if(!isset($absence_abbreviations[$abbreviation])){
            return "!!".$abbreviation."!!";
        } 
        else{
            return $absence_abbreviations[$abbreviation];
        }
    }
    

?>