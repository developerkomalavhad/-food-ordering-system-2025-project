<?php
// Include constants for SITEURL
include('../config/constants.php');

// Start session
session_start();

// Handle logout on form submit
if(isset($_POST['logout'])){
    session_destroy(); // Destroy all session data
    header('Location:'.SITEURL.'admin/login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Logout</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .logout-container {
            background: #fff;
            padding: 40px 60px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            text-align: center;
        }

        .logout-container h2 {
            color: #333;
            margin-bottom: 30px;
        }

        .btn-logout {
            padding: 12px 30px;
            font-size: 18px;
            background-color: #ff4d4d;
            color: #fff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .btn-logout:hover {
            background-color: #cc0000;
        }
    </style>
</head>
<body>
    <div class="logout-container">
        <h2>Are you sure you want to logout?</h2>
        <form method="POST">
            <button type="submit" name="logout" class="btn-logout">Logout</button>
        </form>
    </div>
</body>
</html>
