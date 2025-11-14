<?php 
session_start(); 
include('../config/constants.php'); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Food Order System</title>
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #74ebd5 0%, #ACB6E5 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login {
            background: #fff;
            width: 850px;
            max-width: 95%;
            display: flex;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        .image {
            flex: 1;
        }

        .image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .myform {
            flex: 1;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        h2 {
            text-align: center;
            color: #007bff;
            margin-bottom: 30px;
            font-weight: 600;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-top: 8px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 15px;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        .btn-primary {
            width: 100%;
            background: #007bff;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 500;
            transition: 0.3s;
        }

        .btn-primary:hover {
            background: #0056b3;
            transform: scale(1.03);
        }

        .success, .error {
            text-align: center;
            margin-bottom: 15px;
            font-weight: 500;
            font-size: 15px;
            border-radius: 8px;
            padding: 10px;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
        }

        @media (max-width: 768px) {
            .login {
                flex-direction: column;
                width: 90%;
            }
            .image {
                height: 200px;
            }
        }
    </style>
</head>
<body>
    <div class="login">
        <div class="image">
            <img src="../images/image.jpg" alt="Login Illustration">
        </div>
        <div class="myform">
            <h2>Admin Login</h2>

            <?php 
                if(isset($_SESSION['login'])) {
                    echo $_SESSION['login'];
                    unset($_SESSION['login']);
                }
                if(isset($_SESSION['no-login-message'])) {
                    echo $_SESSION['no-login-message'];
                    unset($_SESSION['no-login-message']);
                }
            ?>

            <form action="" method="POST">
                <label>Username:</label>
                <input type="text" name="username" placeholder="Enter Username" required><br><br>

                <label>Password:</label>
                <input type="password" name="password" placeholder="Enter Password" required><br><br>

                <input type="submit" name="submit" value="Login" class="btn-primary"><br>
            </form>
        </div>
    </div>
</body>
</html>

<?php 
// Handle Login
if(isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, md5($_POST['password'])); // md5 for hashed password

    $sql = "SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";
    $res = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($res);

    if($count==1) {
        $_SESSION['login'] = "<div class='success'>Login Successful.</div>";
        $_SESSION['user'] = $username;
        header('location:'.SITEURL.'admin/index.php');
        exit;
    } else {
        echo "<script>alert('Username or Password is incorrect. Try again.');</script>";
    }
}
?>
