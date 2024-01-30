<?php
// execute_batch.php

// Assuming the batch file is in the same directory as this PHP script
exec('start /b runreact_new.bat', $output, $returnCode);

// Respond to the client
if ($returnCode === 0) {
    echo 'Script executed successfully';
} else {
    echo 'Error executing the script';
}
?>