<?php 
include_once('../config/constants.php'); 
include_once('partials/menu.php'); 
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add User</h1>

        <br><br>

        <?php 
        if(isset($_SESSION['add'])){
            echo $_SESSION['add']; // success / error message
            unset($_SESSION['add']);
        }
        ?>

        <!-- User Add Form -->
        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Username: </td>
                    <td><input type="text" name="username" placeholder="Enter Username" required></td>
                </tr>

                <tr>
                    <td>Password: </td>
                    <td><input type="password" name="password" placeholder="Enter Password" required></td>
                </tr>

                <tr>
                    <td>Full Name: </td>
                    <td><input type="text" name="customer_name" placeholder="Enter Full Name" required></td>
                </tr>

                <tr>
                    <td>Email: </td>
                    <td><input type="email" name="customer_email" placeholder="Enter Email" required></td>
                </tr>

                <tr>
                    <td>Contact: </td>
                    <td><input type="text" name="customer_contact" placeholder="Enter Contact No." required></td>
                </tr>

                <tr>
                    <td>Address: </td>
                    <td><textarea name="customer_address" placeholder="Enter Address" rows="4" cols="30" required></textarea></td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add User" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

    </div>
</div>


<?php
// PHP Code for insert user
if(isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $hash = $_POST['password']; // plain password
    $password = password_hash($hash, PASSWORD_DEFAULT); // hashed password
    $full_name = mysqli_real_escape_string($conn, $_POST['customer_name']);
    $customer_email = mysqli_real_escape_string($conn, $_POST['customer_email']);
    $customer_contact = mysqli_real_escape_string($conn, $_POST['customer_contact']);
    $customer_address = mysqli_real_escape_string($conn, $_POST['customer_address']);

    // check if username already exists
    $check_sql = "SELECT * FROM users WHERE username='$username'";
    $check_res = mysqli_query($conn, $check_sql);

    if(mysqli_num_rows($check_res) > 0){
        $_SESSION['add'] = "<div class='error'>Error! Username not available.</div>";
        header("location:".SITEURL.'admin/add-users.php');
        exit();
    }

    $sql = "INSERT INTO `users` 
            (`username`, `password`, `customer_name`, `customer_email`, `customer_contact`, `customer_address`, `created_at`) 
            VALUES ('$username', '$password', '$full_name', '$customer_email', '$customer_contact', '$customer_address', current_timestamp())";

    $res = mysqli_query($conn, $sql);

    if($res){
        $_SESSION['add'] = "<div class='success'>User Added Successfully.</div>";
        header("location:".SITEURL.'admin/manage-users.php');
        exit();
    } else {
        $_SESSION['add'] = "<div class='error'>Failed to Add User. Error: ".mysqli_error($conn)."</div>";
        header("location:".SITEURL.'admin/add-users.php');
        exit();
    }
}
?>
