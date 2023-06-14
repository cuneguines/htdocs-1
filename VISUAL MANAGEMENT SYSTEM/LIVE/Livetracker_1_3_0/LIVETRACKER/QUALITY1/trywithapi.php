<?php
$accessToken = 'YOUR_ACCESS_TOKEN';
$sendEmailEndpoint = 'https://outlook.office.com/api/v2.0/me/sendmail';

// Email data
$recipientEmail = 'qualityinspector@kentstainless.com';
$subject = 'Subject of the email';
$body = 'Body of the email';

// Create the email JSON payload
$emailData = array(
    'Message' => array(
        'Subject' => $subject,
        'Body' => array(
            'ContentType' => 'Text',
            'Content' => $body
        ),
        'ToRecipients' => array(
            array(
                'EmailAddress' => array(
                    'Address' => $recipientEmail
                )
            )
        )
    ),
    'SaveToSentItems' => 'true'
);

// Convert the email data to JSON
$jsonEmailData = json_encode($emailData);

// Set the cURL request options
$ch = curl_init($sendEmailEndpoint);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonEmailData);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Authorization: Bearer ' . $accessToken
));

// Execute the cURL request
$response = curl_exec($ch);

// Check for errors
if (curl_errno($ch)) {
    echo 'Error: ' . curl_error($ch);
} else {
    echo 'Email sent successfully.';
}

// Close the cURL session
curl_close($ch);
?>
