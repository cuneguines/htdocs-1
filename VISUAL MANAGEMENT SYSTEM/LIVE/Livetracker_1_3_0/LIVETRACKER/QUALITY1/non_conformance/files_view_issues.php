<?php //require_once('Connections/databasestudents.php'); ?>
<?php 
require_once('vendorqlty/autoload.php');

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
    $s="uploads/$filename";
    print_r($s);

    ?>
    <a href="file=<?=$s?>">Download PDF Now</a>
    <form method="get" action="<?=$s?>">
   <button type="submit">Download!</button>
</form>
        <?php
        // This code example demonstrates how to render DOCX to HTML.
// Initialize the api
$apiInstance = new GroupDocs\Viewer\ViewApi($configuration);
$fileApi = new GroupDocs\Viewer\FileApi($configuration);

// Define ViewOptions
$viewOptions = new Model\ViewOptions();

// Input file path
$fileInfo = new Model\FileInfo();
$fileInfo->setFilePath("input.docx");	
$viewOptions->setFileInfo($fileInfo);

// Set ViewFormat
$viewOptions->setViewFormat(Model\ViewOptions::VIEW_FORMAT_HTML);

// Define HTML options
$renderOptions = new Model\HtmlOptions();

// Set it to be responsive
$renderOptions->setIsResponsive(true);

// Set for printing
$renderOptions->setForPrinting(true);

// Assign render options
$viewOptions->setRenderOptions($renderOptions);

// Create view request
$request = new Requests\CreateViewRequest($viewOptions);

// Create view
$response = $apiInstance->createView($request);

// Load an existing HTML file
$domDoc = new DOMDocument();
$domDoc->loadHTMLFile("C:\Files\Viewer\Sample.html");
$body = $domDoc->GetElementsByTagName('body')->item(0);

// Get pages
$pages = $response->getPages();

// Embed all rendered HTML pages into body tag of existing HTML
foreach ($pages as $page)
{
    // Create download file request
    $downloadFileRequest = new GroupDocs\Viewer\Model\Requests\DownloadFileRequest($page->getPath(), "");

    // Download converted page
    $file = $fileApi->DownloadFile($downloadFileRequest);

    // Read HTML from download file
    $html = file_get_contents($file->getRealPath());

    //Add content to fragment
    $fragment = $domDoc->createDocumentFragment();
    $fragment->appendXML("<div>$html</div>");

    // Append the element to body
    $body->appendChild($fragment);
}

// Save updated HTML
$output = $domDoc->saveHTML();

// Save the file
file_put_contents("C:\Files\Viewer\Sample.html", $output);
}
?>