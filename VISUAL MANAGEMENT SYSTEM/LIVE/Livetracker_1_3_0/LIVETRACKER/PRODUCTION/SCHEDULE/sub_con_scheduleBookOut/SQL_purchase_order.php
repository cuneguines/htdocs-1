<?php include '../../../../SQL CONNECTIONS/conn.php'; ?>
<?php 
if(isset($_POST['item'])) {
    $item=(!empty($_POST['item'])? $_POST['item'] : 0);}
$purchase_results="select t0.ItemCode,t0.U_IIS_proPrOrder,t1.DocNum
                           
                            from por1 t0
        
                            INNER JOIN opor t1 ON t1.DocEntry = t0.DocEntry        
                            where t1.DocStatus = 'O'
                          and t0.U_IIS_proPrOrder=$item";
$getResults = $conn->prepare($purchase_results);
$getResults->execute();
$pur_results = $getResults->fetchAll(PDO::FETCH_BOTH);
//$json_array = array();
//var_dump($production_exceptions_results);
echo json_encode(array($pur_results));
                            ?>      
                          
                 