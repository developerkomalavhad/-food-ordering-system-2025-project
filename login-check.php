<?php
// Start session only if not started
if(session_status() == PHP_SESSION_NONE){
    session_start();
}

// Include constants.php with correct path
include('../config/constants.php'); 

// Check whether the user is logged in or not
if(!isset($_SESSION['user'])) {
    // User is not logged in
    $_SESSION['no-login-message'] = "<div class='error text-center'>Please login to access Admin Panel.</div>";
    
    // Redirect to Admin Login Page
    header('location:' . SITEURL . 'admin/login.php'); 
    exit;
}
?>
