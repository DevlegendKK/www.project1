<?php
$host = 'localhost';
$db = 'u68cdialog';
$user = 'u687264log';
$pass = 'e@267%$';

try {
    // Create a new PDO instance
    $conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // echo "Connected successfully"; 
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

?>
