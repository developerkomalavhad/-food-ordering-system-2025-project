<?php include('partials/menu.php'); ?>

<style>
/* ======= Overall Page Layout ======= */
.wrapper {
    width: 85%;
    margin: 40px auto;
    background: #ffffff;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 0 15px rgba(0,0,0,0.08);
    font-family: 'Segoe UI', sans-serif;
}

.page-title {
    text-align: center;
    font-size: 28px;
    color: #333;
    font-weight: bold;
    border-bottom: 3px solid #ffa41b;
    display: inline-block;
    padding-bottom: 6px;
    margin-bottom: 30px;
}

/* ======= Form Section ======= */
.form-container {
    background: #fafafa;
    border: 1px solid #eee;
    border-radius: 12px;
    padding: 20px 25px;
    margin-bottom: 40px;
}

.form-container table {
    width: 100%;
}

.form-container td {
    padding: 12px 10px;
    font-size: 16px;
    color: #444;
}

input[type="text"], input[type="file"], select {
    width: 100%;
    padding: 10px;
    border-radius: 6px;
    border: 1px solid #ccc;
    outline: none;
    font-size: 15px;
    transition: all 0.3s ease;
}

input[type="text"]:focus {
    border-color: #ffa41b;
    box-shadow: 0 0 4px rgba(255,164,27,0.5);
}

input[type="file"] {
    background: #fff;
}

input[type="radio"] {
    transform: scale(1.2);
    margin-right: 6px;
}

/* ======= Buttons ======= */
.btn-secondary {
    background-color: #ffa41b;
    color: #fff;
    padding: 10px 18px;
    border-radius: 6px;
    text-decoration: none;
    border: none;
    cursor: pointer;
    font-weight: 600;
    transition: all 0.3s ease;
}
.btn-secondary:hover {
    background-color: #ff8800;
    transform: scale(1.05);
}

.btn-danger {
    background-color: #dc3545;
    color: #fff;
    padding: 8px 14px;
    border-radius: 6px;
    text-decoration: none;
    border: none;
    cursor: pointer;
    font-weight: 600;
    transition: all 0.3s ease;
}
.btn-danger:hover {
    background-color: #c82333;
    transform: scale(1.05);
}

/* ======= Messages ======= */
.success {
    background: #d4edda;
    color: #155724;
    border-left: 5px solid #28a745;
    padding: 10px 15px;
    border-radius: 6px;
    margin-bottom: 15px;
}
.error {
    background: #f8d7da;
    color: #721c24;
    border-left: 5px solid #dc3545;
    padding: 10px 15px;
    border-radius: 6px;
    margin-bottom: 15px;
}

/* ======= Table Styling ======= */
.tbl-full {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.tbl-full th {
    background-color: #ffa41b;
    color: #fff;
    padding: 12px 10px;
    text-align: left;
    font-size: 16px;
}

.tbl-full td {
    padding: 10px;
    font-size: 15px;
    color: #333;
    border-bottom: 1px solid #eee;
}

.tbl-full tr:nth-child(even) {
    background-color: #f9f9f9;
}

.tbl-full tr:hover {
    background-color: #fff5e6;
    transition: 0.3s ease;
}

.tbl-full img {
    border-radius: 8px;
    border: 1px solid #ddd;
    background: #fff;
    padding: 4px;
}

/* ======= Responsive Design ======= */
@media (max-width: 768px) {
    .wrapper {
        width: 95%;
        padding: 20px;
    }

    .tbl-full, .tbl-full th, .tbl-full td {
        display: block;
        width: 100%;
    }

    .tbl-full th {
        text-align: left;
    }

    .tbl-full td {
        padding: 8px;
    }

    .form-container table, .form-container td {
        display: block;
        width: 100%;
    }

    .page-title {
        font-size: 22px;
    }
}
</style>


<div class="main-content">
    <div class="wrapper">
        <h1 class="page-title">Manage Categories</h1>

        <?php 
            if(isset($_SESSION['add'])){ echo $_SESSION['add']; unset($_SESSION['add']); }
            if(isset($_SESSION['upload'])){ echo $_SESSION['upload']; unset($_SESSION['upload']); }
            if(isset($_SESSION['delete'])){ echo $_SESSION['delete']; unset($_SESSION['delete']); }
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

        <?php
        if(isset($_POST['submit']))
        {
            $title = $_POST['title'];
            $featured = isset($_POST['featured']) ? $_POST['featured'] : "No";
            $active = isset($_POST['active']) ? $_POST['active'] : "No";
            $image_name = "";

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
                    if(!$upload)
                    {
                        $_SESSION['upload'] = "<div class='error'>Failed to Upload Image.</div>";
                        header('location:'.SITEURL.'admin/manage-category.php');
                        die();
                    }
                }
            }

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
                header('location:'.SITEURL.'admin/manage-category.php');
            }
        }
        ?>

        <table class="tbl-full">
            <tr>
                <th>S.N</th>
                <th>Title</th>
                <th>Image</th>
                <th>Featured</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>

            <?php
                $sql = "SELECT * FROM tbl_category";
                $res = mysqli_query($conn, $sql);
                $sn = 1;

                while($row = mysqli_fetch_assoc($res))
                {
                    $id = $row['id'];
                    $title = $row['title'];
                    $image_name = $row['image_name'];
                    $featured = $row['featured'];
                    $active = $row['active'];
                    ?>
                    <tr>
                        <td><?php echo $sn++; ?></td>
                        <td><?php echo $title; ?></td>
                        <td>
                            <?php 
                                if($image_name != "")
                                    echo "<img src='../images/category/$image_name' width='100px'>";
                                else
                                    echo "<div class='error'>Image not added</div>";
                            ?>
                        </td>
                        <td><?php echo $featured; ?></td>
                        <td><?php echo $active; ?></td>
                        <td>
                            <a href="<?php echo SITEURL; ?>admin/update-category.php?id=<?php echo $id; ?>" class="btn-secondary">Update</a>
                            <a href="<?php echo SITEURL; ?>admin/delete-category.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-danger">Delete</a>
                        </td>
                    </tr>
                    <?php
                }
            ?>
        </table>
    </div>
</div>

<?php include('partials/footer.php'); ?>
