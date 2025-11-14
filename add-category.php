<?php include('partials/menu.php'); ?>

<?php
// Handle form submission
if(isset($_POST['submit']))
{
    $title = $_POST['title'];
    $featured = isset($_POST['featured']) ? $_POST['featured'] : "No";
    $active = isset($_POST['active']) ? $_POST['active'] : "No";

    // Image Upload
    if(isset($_FILES['image']['name']))
    {
        $image_name = $_FILES['image']['name'];
        if($image_name != "")
        {
            $ext = pathinfo($image_name, PATHINFO_EXTENSION);
            $image_name = "Food_Category_".rand(000,999).'.'.$ext;
            $source_path = $_FILES['image']['tmp_name'];
            $destination_path = "../images/category/".$image_name;
            $upload = move_uploaded_file($source_path, $destination_path);

            if($upload==false)
            {
                $_SESSION['upload'] = "<div class='error'>Failed to Upload Image.</div>";
                header('location:'.SITEURL.'admin/add-category.php');
                die();
            }
        }
    }
    else
    {
        $image_name="";
    }

    // Insert into Database
    $sql = "INSERT INTO tbl_category SET 
        title='$title',
        image_name='$image_name',
        featured='$featured',
        active='$active'";

    $res = mysqli_query($conn, $sql);

    if($res==true)
    {
        $_SESSION['add'] = "<div class='success'>Category Added Successfully.</div>";
        header('location:'.SITEURL.'admin/manage-category.php');
    }
    else
    {
        $_SESSION['add'] = "<div class='error'>Failed to Add Category.</div>";
        header('location:'.SITEURL.'admin/add-category.php');
    }
}
?>

<!-- Internal CSS -->
<style>
body {
    font-family: Arial, sans-serif;
    background: #f4f4f4;
}

.wrapper {
    width: 70%;
    margin: 0 auto;
}

.page-title {
    font-size: 28px;
    color: #333;
    text-align: center;
    margin-bottom: 20px;
}

.form-container {
    background: #fff;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    margin-bottom: 40px;
}

.form-container table {
    width: 100%;
    border-collapse: collapse;
}

.form-container td {
    padding: 12px;
    vertical-align: middle;
}

.form-container input[type="text"],
.form-container input[type="file"] {
    width: 100%;
    padding: 10px 15px;
    border-radius: 8px;
    border: 1px solid #ccc;
    font-size: 16px;
}

.form-container input[type="radio"] {
    margin-right: 5px;
    transform: scale(1.2);
    margin-left: 10px;
}

.btn-secondary {
    background: #007bff;
    color: #fff;
    padding: 12px 25px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 16px;
    transition: background 0.3s ease;
}

.btn-secondary:hover {
    background: #0056b3;
}

.success {
    background: #d4edda;
    color: #155724;
    padding: 10px;
    border-radius: 8px;
    margin-bottom: 20px;
    text-align: center;
}

.error {
    background: #f8d7da;
    color: #721c24;
    padding: 10px;
    border-radius: 8px;
    margin-bottom: 20px;
    text-align: center;
}

.footer {
    background: #f1f1f1;
    padding: 20px 0;
    color: #333;
    font-size: 14px;
    text-align: center;
}
</style>

<div class="main-content">
    <div class="wrapper">
        <h1 class="page-title">Add Category</h1>

        <?php 
            if(isset($_SESSION['add'])){
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }
            if(isset($_SESSION['upload'])){
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
        ?>

        <div class="form-container">
            <form action="" method="POST" enctype="multipart/form-data">
                <table>
                    <tr>
                        <td>Title: </td>
                        <td><input type="text" name="title" placeholder="Category Title" required></td>
                    </tr>
                    <tr>
                        <td>Select Image: </td>
                        <td><input type="file" name="image"></td>
                    </tr>
                    <tr>
                        <td>Featured: </td>
                        <td>
                            <input type="radio" name="featured" value="Yes"> Yes 
                            <input type="radio" name="featured" value="No" checked> No 
                        </td>
                    </tr>
                    <tr>
                        <td>Active: </td>
                        <td>
                            <input type="radio" name="active" value="Yes"> Yes 
                            <input type="radio" name="active" value="No" checked> No 
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>

<div class="footer">
    <p>© 2025 All rights reserved. Online Food Ordering System.<br>
    Developed by <strong>Komal Avhad & Ganesh Shejul</strong><br>
    Trimurti Arts, Commerce & Science College, Dhorjalgaon-Ne, Tal. Shegaon, Dist. Ahilyanagar</p>
</div>
