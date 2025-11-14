<?php
include('config/constants.php');

$showAlert = false;
$showError = false;
$exists = false;

if($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);
    $cpassword = trim($_POST["cpassword"]);
    $customer_name = trim($_POST["customer_name"]);
    $customer_email = trim($_POST["customer_email"]);
    $customer_contact = trim($_POST["customer_contact"]);
    $customer_address = trim($_POST["customer_address"]);

    // Check if username exists
    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);

    if($num == 0) {
        if($password === $cpassword) {
            // Use simple password (plain text)
            $sql = "INSERT INTO users (username, password, customer_name, customer_email, customer_contact, customer_address, created_at) 
                    VALUES ('$username', '$password', '$customer_name', '$customer_email', '$customer_contact', '$customer_address', current_timestamp())";

            $result = mysqli_query($conn, $sql);
            if($result){
                $showAlert = true;
            }
        } else {
            $showError = "Passwords do not match!";
        }
    } else {
        $exists = "Username not available!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Signup</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">

<style>
body {
    background: linear-gradient(135deg, #74ebd5 0%, #ACB6E5 100%);
    font-family: 'Poppins', sans-serif;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}

.container {
    background: #fff;
    padding: 30px 40px;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    width: 450px;
}

h2 {
    text-align: center;
    color: #007bff;
    font-weight: 600;
    margin-bottom: 10px;
}

h5 {
    text-align: center;
    color: #666;
    margin-bottom: 25px;
}

.form-group label {
    font-weight: 500;
    color: #333;
}

.form-control {
    border-radius: 8px;
    padding: 10px;
}

.btn-primary {
    width: 100%;
    border-radius: 10px;
    background: #007bff;
    font-size: 16px;
    font-weight: 500;
    padding: 10px;
    border: none;
    transition: 0.3s;
}

.btn-primary:hover {
    background: #0056b3;
    transform: scale(1.03);
}

.alert {
    border-radius: 10px;
    font-size: 15px;
}
</style>
</head>
<body>

<div class="container">
<h2>Signup Here</h2>
<h5>*All fields are required</h5>

<?php
if($showAlert){
    echo '<div class="alert alert-success">Account created successfully! <a href="login.php" class="alert-link">Login here</a></div>';
}
if($showError){
    echo '<div class="alert alert-danger">'.$showError.'</div>';
}
if($exists){
    echo '<div class="alert alert-danger">'.$exists.'</div>';
}
?>

<form action="" method="post">
    <div class="form-group">
        <label>Username</label>
        <input type="text" name="username" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Full Name</label>
        <input type="text" name="customer_name" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Confirm Password</label>
        <input type="password" name="cpassword" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Email</label>
        <input type="email" name="customer_email" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Phone</label>
        <input type="number" name="customer_contact" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Address</label>
        <textarea name="customer_address" class="form-control" required></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Sign Up</button>
</form>
</div>

</body>
</html>
