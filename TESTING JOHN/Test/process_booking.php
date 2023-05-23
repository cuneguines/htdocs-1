<?php
// Retrieve form data
$name = $_POST['name'];
$email = $_POST['email'];
$date = $_POST['date'];
$start_time = $_POST['start-time'];
$end_time = $_POST['end-time'];
$space = $_POST['space'];
echo "<h1>Booking Confirmation</h1>";
echo "<p><strong>Name:</strong> $name</p>";
echo "<p><strong>Email:</strong> $email</p>";
echo "<p><strong>Date:</strong> $date</p>";
echo "<p><strong>Time:</strong> $start_time - $end_time</p>";
echo "<p><strong>Space Type:</strong> $space</p>";
?>
// Validate form inputs (perform any necessary validation here)

// Process the booking (store in a database, send confirmation email, etc.)
// Replace the database credentials with your own
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "space_booking";

// Create a database connection
/* $conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and execute the SQL statement to insert the booking details into the database
$stmt = $conn->prepare("INSERT INTO bookings (name, email, date, start_time, end_time, space) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $name, $email, $date, $start_time, $end_time, $space);
$stmt-> */