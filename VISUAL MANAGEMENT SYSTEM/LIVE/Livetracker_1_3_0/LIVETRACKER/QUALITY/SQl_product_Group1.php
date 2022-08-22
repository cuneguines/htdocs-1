<?php include '../../SQL CONNECTIONS/conn.php'; ?>
<?php
//echo json_encode($_POST);
$item=(!empty($_POST['item'])? $_POST['item'] : 0);

try{
   
$Quality_results="select t0.code, t0.CreateDate, t0.UpdateDate, t0.U_area_nc, t0.U_area_nc_raised, 
t2.ItemCode, t2.ItemName, t2.U_Product_Group_One, t2.U_Product_Group_Two, t2.U_Product_Group_Three,
t3.ItmsGrpNam [Item Group], 
t0.U_Status, t0.U_nc_type, t0.U_nc_observation, t0.U_prev_action_owner, t0.U_root_cause_analysis, 
t0.U_prev_action_report, 
 t1.U_Description,
(case 

        WHEN  t1.U_Attachments is null  then 'N' else t1.U_Attachments

END) [attachements_issues]

from [dbo].[@QUALITY] t0
inner join [dbo].[@QUAL_ATTACH] t1 on t1.Code = t0.Code
left join oitm t2 on t2.ItemCode = t0.U_itemcode
left join oitb t3 on t3.ItmsGrpCod = t2.ItmsGrpCod where t2.U_Product_Group_One='$item'";
$getResults = $conn->prepare($Quality_results);
$getResults->execute();
$production_exceptions_results = $getResults->fetchAll(PDO::FETCH_BOTH);
//$json_array = array();
//var_dump($production_exceptions_results);
echo json_encode(array('data'=>$production_exceptions_results));
}

catch(PDOException $e)

{
echo $e->getMessage();
}  
?>

