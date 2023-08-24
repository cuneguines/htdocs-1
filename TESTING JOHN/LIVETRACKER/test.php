<!DOCTYPE html>
<html>
<head>
  <title>Session Data Debugging</title>
</head>
<body>
  <h1>Logged-In Area</h1>
  
 
   <?php
    // Debugging Issue: Session data persistence
    ?>
    <form method='post'>
    <input name='username'>
    <input name='password'>
    <button type='submit' name ='log'>LOGIN</button>
    
    
  </body>
  
  
  <p><a href="dashboard.php">Go to Dashboard</a></p>
</body>
</html>


<?php 
session_start();
if (isset($_POST['log']))
{
$username = $_POST['username'];
$password = $_POST['password'];
}
$validCredentials = ['admin' => 'secretpassword'];

if (isset($validCredentials[$username]) && $validCredentials[$username] === $password) {
    echo "Welcome, Administrator!";
} else {
    echo "Invalid credentials";
}
var_dump($_SESSION);

$filename = "data.txt";
$data = "Hello, world!";

$file = fopen($filename, "w");
fwrite($file, $data);

fclose($file);
$filename = "data.txt";

if (file_exists($filename)) {
    $fileContent = file_get_contents($filename);
    echo "Content of $filename: $fileContent";
} else {
    echo "$filename does not exist.";
}

echo "Data written to $filename";
?>
<?php
$students = [
    [
        'name' => 'Alice',
        'age' => 20,
        'courses' => ['Math', 'Physics']
    ],
    [
        'name' => 'Bob',
        'age' => 22,
        'courses' => ['Computer Science', 'English']
    ],
    [
        'name' => 'Charlie',
        'age' => 21,
        'courses' => ['History', 'Chemistry']
    ]
];

foreach ($students as $student) {
    echo "Name: " . $student['name'] . "\n";
    echo "Age: " . $student['age'] . "\n";
    
   foreach ($student['courses'] as $course){
    echo "Courses: " .  $course . "\n\n";
    }
}


$employees = [
    ['name' => 'Alice', 'department' => 'HR'],
    ['name' => 'Bob', 'department' => 'Engineering'],
    ['name' => 'Charlie', 'department' => 'Sales']
];

$departments = [];

foreach ($employees as $employee) {
    $departments[] = $employee['department'];
}

$uniqueDepartments = array_unique($departments);

echo "Unique departments: " . implode(', ', $uniqueDepartments);


?>
<?php
$students = [
    ['name' => 'Alice', 'score' => 85],
    ['name' => 'Bob', 'score' => 72],
    ['name' => 'Charlie', 'score' => 93],
    ['name' => 'David', 'score' => 68]
];

// Sort students by score in descending order
usort($students);

echo "Top Students:\n";
foreach ($students as $student) {
    echo "{$student['name']} - Score: {$student['score']}\n";
}
?>
