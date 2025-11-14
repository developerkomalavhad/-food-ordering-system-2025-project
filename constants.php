<?php
// Define SITEURL only if not already defined
if(!defined('SITEURL')){
    define('SITEURL', 'http://localhost/food/');
}

// Database connection
$servername = "localhost";
$username = "root";  // your DB username
$password = "";      // your DB password
$database = "food_order";  // your DB name

$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if(!$conn){
    die("Connection failed: " . mysqli_connect_error());
}
?>
