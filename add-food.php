<?php 
ob_start(); // Start output buffering
include('partials/menu.php'); 
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>
        <br><br>

        <?php 
        // Display upload message if exists
        if(isset($_SESSION['upload']))
        {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td><input type="text" name="title" placeholder="Title of the Food" required></td>
                </tr>

                <tr>
                    <td>Description: </td>
                    <td><textarea name="description" cols="30" rows="5" placeholder="Description of the Food." required></textarea></td>
                </tr>

                <tr>
                    <td>Price: </td>
                    <td><input type="number" name="price" required></td>
                </tr>

                <tr>
                    <td>Select Image: </td>
                    <td><input type="file" name="image"></td>
                </tr>

                <tr>
                    <td>Category: </td>
                    <td>
                        <select name="category" required>
                            <?php 
                                $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                                $res = mysqli_query($conn, $sql);
                                $count = mysqli_num_rows($res);

                                if($count > 0)
                                {
                                    while($row = mysqli_fetch_assoc($res))
                                    {
                                        $id = $row['id'];
                                        $title = $row['title'];
                                        echo "<option value='$id'>$title</option>";
                                    }
                                }
                                else
                                {
                                    echo "<option value='0'>No Category Found</option>";
                                }
                            ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type="radio" name="featured" value="Yes" checked> Yes 
                        <input type="radio" name="featured" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" name="active" value="Yes" checked> Yes 
                        <input type="radio" name="active" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php 
        if(isset($_POST['submit']))
        {
            $title = mysqli_real_escape_string($conn, $_POST['title']);
            $description = mysqli_real_escape_string($conn, $_POST['description']);
            $price = $_POST['price'];
            $category = $_POST['category'];
            $featured = isset($_POST['featured']) ? $_POST['featured'] : "No";
            $active = isset($_POST['active']) ? $_POST['active'] : "No";

            // Upload image if selected
            $image_name = "";
            if(isset($_FILES['image']['name']) && $_FILES['image']['name'] != "")
            {
                $image_name = $_FILES['image']['name'];
                $ext_arr = explode('.', $image_name);
                $ext = end($ext_arr);
                $image_name = "Food-Name-".rand(0000,9999).".".$ext;
                $src = $_FILES['image']['tmp_name'];
                $dst = "../images/food/".$image_name;

                $upload = move_uploaded_file($src, $dst);
                if(!$upload)
                {
                    echo "<div style='color:red;'>Failed to Upload Image.</div>";
                    die();
                }
            }

            // Insert into Database
            $sql2 = "INSERT INTO tbl_food SET 
                title='$title',
                description='$description',
                price=$price,
                image_name='$image_name',
                category_id=$category,
                featured='$featured',
                active='$active'";

            $res2 = mysqli_query($conn, $sql2);

            if($res2)
            {
                echo "<div style='color:green; font-weight:bold;'>Food Added Successfully!</div>";
            }
            else
            {
                echo "<div style='color:red; font-weight:bold;'>Failed to Add Food.</div>";
            }
        }
        ?>
    </div>
</div>

<?php include('partials/footer.php'); ?>
<?php ob_end_flush(); ?>
