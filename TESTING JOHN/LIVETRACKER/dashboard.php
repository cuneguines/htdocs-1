
<!DOCTYPE html>
<html>
<head>
  <title>Error Logging</title>
</head>
<body>
  <h1>Debugging with Error Logging</h1>
  
  <?php
    // Debugging Issue: Blank screen with no error messages
    // Debugging Solution: Set up error logging
    
    // Set error reporting level
    error_reporting(E_ALL);
    ini_set('display_errors', 1); // Display errors on screen
    
    // Enable error logging to a file
    //ini_set('log_errors', 1);
    //ini_set('error_log', 'error.log');
    
    // Simulate a division by zero error
    $result = 10 / 5;
    
    echo "Result: $result";
  ?>
</body>
</html>
<!DOCTYPE html>
<html>
<head>
    <title>Product List</title>
</head>
<body>
    <h1>Products Available:</h1>
    <?php
    $products = [
        'Product A' => 20,
        'Product B' => 15,
        'Product C' => 10
    ];

    foreach ($products as $product => $price) {
        echo "<p>$product: $$price</p>";
    }
    ?>
</body>
</html>
<!DOCTYPE html>
<html>
<head>
    <title>User List</title>
</head>
<body>
    <h1>User List</h1>
    <?php
    $users = [
        ['name' => 'Alice', 'age' => 25],
        ['name' => 'Bob', 'age' => 30],
        ['name' => 'Carol', 'age' => 28]
    ];

    foreach ($users as $user) {
        echo "<p>Name: ".$user['name'].", Age: ".$user['age']."</p>";
    }
    ?>
</body>
</html>
<?php
$arry=[1,1,2,3,3,3,4];
$count_each=[];
$big=0;
$most=0;
for ($i=0;$i<=count($arry)-1;$i++)
{
    $count=0;
    for ($j=$i+1;$j<=count($arry)-1;$j++)
    {
        if ($arry[$i]==$arry[$j])
        {
         $count_each[$i]=$count+1;
        }
         $big=$count;
         print($big);
    
    if ($big>$count)
    {
        $most=$arr[$i];
    }
}
}
print($most);

function calculateSum($a, $b) {
    return $a + $b;
}

$num1 = 10;
$num2 = 5;
$result = calculateSum($num1, $num2);
echo "The sum of $num1 and $num2 is: $result";
?>
<?php
error_reporting(E_ALL);
ini_set('display',1);
$users = [
    ['id' => 1, 'name' => 'Alice', 'email' => 'alice@example.com'],
    ['id' => 2, 'name' => 'Bob', 'email' => 'bob@example.com'],
    ['id' => 3, 'name' => 'Charlie', 'email' => 'charlie@example.com']
];

function getUserById($userId) {
    global $users;
    foreach ($users as $user) {
        if ($user['id'] === $userId) {
            return $user;
        }
    }
    return null;
}

$userId = 2;
$user = getUserById($userId);

if ($user) {
    echo "User found: {$user['name']} ({$user['email']})";
} else {
    echo "User not found";
}
?>
<?php
$colors = ['red', 'green', 'blue'];

function displayColors($colors) {
    foreach ($colors as $color) {
        echo ucfirst($color) . " ";
    }
}

displayColors($colors);
?>
<?php
function generateRandomNumbers($count) {
    $numbers = [];
    for ($i = 0; $i < $count; $i++) {
        $numbers[] = rand(1, 100);
    }
    return $numbers;
}

$numberCount = 5;
$randomNumbers = generateRandomNumbers($numberCount);

echo "Random numbers generated: " . implode(", ", $randomNumbers);
?>
<!-- <?php
/* $username = $_POST['username'];
$password = $_POST['password'];

if ($username === 'admin' && $password === 'secretpassword') {
    echo "Welcome, Administrator!";
} else {
    echo "Invalid credentials";
} */
?>
<?php 
$username = $_POST['username'];
$password = $_POST['password'];

$validCredentials = ['admin' => 'secretpassword'];

if (isset($validCredentials[$username]) && $validCredentials[$username] === $password) {
    echo "Welcome, Administrator!";
} else {
    echo "Invalid credentials";
}
var_dump($_SESSION);
?>
