<?php //require_once('Connections/databasestudents.php'); ?>
<?php 
$conn = new PDO("sqlsrv:Server=KPTSVSP;Database=LEARNING_LOG","sa","SAPB1Admin");
// CREATE QUERY EXECUTION FUNCTION
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$item = (!empty($_GET['q']) ? $_GET['q'] : 0);
if (isset($_GET['q']))
    $item = $_GET['q'];
    //$id = '2'; // ID of entry you wish to view.  To use this enter "view.php?id=x" where x is the entry you wish to view. 
echo($item);
    
    $result = "select 
    t2.attachments from dbo.attachment_table t2 inner join( select sap_id,max(created_date) as max 
    
    from dbo.attachment_table t0 group by sap_id)t5 on t5.max=t2.created_date  where t2.sap_id=$item";
$getResults = $conn->prepare($result);
$getResults->execute();
$file_results = $getResults->fetchAll(PDO::FETCH_BOTH);
print_r($file_results);


foreach ($file_results as $fname) {
    $filename = json_encode($fname[0]);
    print_r($filename);
   $filename=str_replace('"', '', $filename);
   //$filename=str_replace('.', '', $filename);
    $s="../../LIVETRACKER/QUALITY1/non_conformance/uploads/$filename";
    print_r($s);

    ?>
    <a href="file=<?=$s?>">Download PDF Now</a>
    <form method="get" action="<?=$s?>">
   <button type="submit">Download!</button>
</form>
        <?php
}
?>