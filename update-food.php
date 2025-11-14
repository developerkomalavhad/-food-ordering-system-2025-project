<?php include('partials/menu.php'); ?>

<style>
/* ---------- Page Layout ---------- */
.wrapper {
    width: 80%;
    margin: 40px auto;
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 0 15px rgba(0,0,0,0.1);
    padding: 40px;
}

h1 {
    text-align: center;
    color: #333;
    font-size: 28px;
    letter-spacing: 1px;
    margin-bottom: 30px;
    border-bottom: 3px solid #ffa41b;
    display: inline-block;
    padding-bottom: 5px;
}

/* ---------- Table Layout ---------- */
.tbl-30 {
    width: 100%;
    border-collapse: collapse;
}

.tbl-30 td {
    padding: 12px 15px;
    vertical-align: top;
    font-size: 16px;
    color: #444;
}

.tbl-30 input[type="text"],
.tbl-30 input[type="number"],
.tbl-30 input[type="file"],
.tbl-30 textarea,
.tbl-30 select {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid #ccc;
    border-radius: 6px;
    outline: none;
    font-size: 15px;
    transition: all 0.3s ease;
}

.tbl-30 input[type="text"]:focus,
.tbl-30 input[type="number"]:focus,
.tbl-30 textarea:focus,
.tbl-30 select:focus {
    border-color: #ffa41b;
    box-shadow: 0 0 4px rgba(255,164,27,0.6);
}

textarea {
    resize: vertical;
    min-height: 100px;
}

/* ---------- Image Section ---------- */
.tbl-30 img {
    border-radius: 10px;
    border: 1px solid #ddd;
    padding: 5px;
    background-color: #fafafa;
}

/* ---------- Buttons ---------- */
.btn-secondary {
    background: #ffa41b;
    color: #fff;
    padding: 10px 18px;
    border-radius: 6px;
    border: none;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-secondary:hover {
    background: #ff8800;
    transform: scale(1.05);
}

/* ---------- Messages ---------- */
.success {
    background: #d4edda;
    color: #155724;
    border-left: 5px solid #28a745;
    padding: 10px 15px;
    border-radius: 6px;
    margin: 10px 0;
}

.error {
    background: #f8d7da;
    color: #721c24;
    border-left: 5px solid #dc3545;
    padding: 10px 15px;
    border-radius: 6px;
    margin: 10px 0;
}

/* ---------- Radio Buttons ---------- */
input[type="radio"] {
    transform: scale(1.2);
    margin-right: 6px;
}

/* ---------- Responsive ---------- */
@media screen and (max-width: 768px) {
    .wrapper {
        width: 95%;
        padding: 20px;
    }

    .tbl-30 td {
        display: block;
        width: 100%;
    }

    .tbl-30 input,
    .tbl-30 select,
    .tbl-30 textarea {
        width: 100%;
    }

    h1 {
        font-size: 22px;
    }
}
</style>

<?php 
//Check whether id is set or not 
if(isset($_GET['id']))
{
    $id = $_GET['id'];
    $sql2 = "SELECT * FROM tbl_food WHERE id=$id";
    $res2 = mysqli_query($conn, $sql2);
    $row2 = mysqli_fetch_assoc($res2);
    $title = $row2['title'];
    $description = $row2['description'];
    $price = $row2['price'];
    $current_image = $row2['image_name'];
    $current_category = $row2['category_id'];
    $featured = $row2['featured'];
    $active = $row2['active'];
}
else
{
    header('location:'.SITEURL.'admin/manage-food.php');
    exit();
}
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Food</h1>
        <br><br>

        <form action="" method="POST" enctype="multipart/form-data">
        
        <table class="tbl-30">
            <tr>
                <td>Title: </td>
                <td><input type="text" name="title" value="<?php echo $title; ?>"></td>
            </tr>

            <tr>
                <td>Description: </td>
                <td><textarea name="description" cols="30" rows="5"><?php echo $description; ?></textarea></td>
            </tr>

            <tr>
                <td>Price: </td>
                <td><input type="number" name="price" value="<?php echo $price; ?>"></td>
            </tr>

            <tr>
                <td>Current Image: </td>
                <td>
                    <?php 
                        if($current_image == "")
                            echo "<div class='error'>Image not Available.</div>";
                        else
                            echo "<img src='".SITEURL."images/food/$current_image' width='150px'>";
                    ?>
                </td>
            </tr>

            <tr>
                <td>Select New Image: </td>
                <td><input type="file" name="image"></td>
            </tr>

            <tr>
                <td>Category: </td>
                <td>
                    <select name="category">
                        <?php 
                            $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                            $res = mysqli_query($conn, $sql);
                            $count = mysqli_num_rows($res);

                            if($count>0)
                            {
                                while($row=mysqli_fetch_assoc($res))
                                {
                                    $category_title = $row['title'];
                                    $category_id = $row['id'];
                                    ?>
                                    <option <?php if($current_category==$category_id){echo "selected";} ?> value="<?php echo $category_id; ?>"><?php echo $category_title; ?></option>
                                    <?php
                                }
                            }
                            else
                            {
                                echo "<option value='0'>Category Not Available.</option>";
                            }
                        ?>
                    </select>
                </td>
            </tr>

            <tr>
                <td>Featured: </td>
                <td>
                    <input <?php if($featured=="Yes") {echo "checked";} ?> type="radio" name="featured" value="Yes"> Yes 
                    <input <?php if($featured=="No") {echo "checked";} ?> type="radio" name="featured" value="No"> No 
                </td>
            </tr>

            <tr>
                <td>Active: </td>
                <td>
                    <input <?php if($active=="Yes") {echo "checked";} ?> type="radio" name="active" value="Yes"> Yes 
                    <input <?php if($active=="No") {echo "checked";} ?> type="radio" name="active" value="No"> No 
                </td>
            </tr>

            <tr>
                <td>
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                    <input type="submit" name="submit" value="Update Food" class="btn-secondary">
                </td>
            </tr>
        </table>
        </form>

        <?php 
        if(isset($_POST['submit']))
        {
            $id = $_POST['id'];
            $title = $_POST['title'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $current_image = $_POST['current_image'];
            $category = $_POST['category'];
            $featured = $_POST['featured'];
            $active = $_POST['active'];

            if(isset($_FILES['image']['name']))
            {
                $image_name = $_FILES['image']['name'];
                if($image_name!="")
                {
                    $temp = explode('.', $image_name);
                    $ext = end($temp);
                    $image_name = "Food-Name-".rand(0000, 9999).'.'.$ext;
                    $src_path = $_FILES['image']['tmp_name'];
                    $dest_path = "../images/food/".$image_name;
                    $upload = move_uploaded_file($src_path, $dest_path);
                    if(!$upload)
                    {
                        $_SESSION['upload'] = "<div class='error'>Failed to Upload new Image.</div>";
                        header('location:'.SITEURL.'admin/manage-food.php');
                        exit();
                    }
                    if($current_image!="")
                    {
                        $remove_path = "../images/food/".$current_image;
                        if(file_exists($remove_path)) unlink($remove_path);
                    }
                }
                else
                {
                    $image_name = $current_image;
                }
            }
            else
            {
                $image_name = $current_image;
            }

            $sql3 = "UPDATE tbl_food SET 
                title = '$title',
                description = '$description',
                price = $price,
                image_name = '$image_name',
                category_id = '$category',
                featured = '$featured',
                active = '$active'
                WHERE id=$id
            ";

            $res3 = mysqli_query($conn, $sql3);

            if($res3)
                $_SESSION['update'] = "<div class='success'>Food Updated Successfully.</div>";
            else
                $_SESSION['update'] = "<div class='error'>Failed to Update Food.</div>";

            header('location:'.SITEURL.'admin/manage-food.php');
            exit();
        }
        ?>
    </div>
</div>

<?php include('partials/footer.php'); ?>
