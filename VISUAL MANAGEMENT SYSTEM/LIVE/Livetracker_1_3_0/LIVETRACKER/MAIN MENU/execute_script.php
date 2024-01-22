<?php
// Execute the batch file
exec('start C:\\Users\\cnixon\\OneDrive - Kent Stainless\\Desktop\\runreact_new.bat', $output, $returnCode);

// You can add more error handling if needed

// Respond to the client
if ($returnCode === 0) {
    echo 'Script executed successfully';
} else {
    echo 'Error executing the script';
}
?>
