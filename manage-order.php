<?php include('partials/menu.php'); ?>

<style>
/* ====== Manage Orders Page Styling ====== */
.wrapper {
    width: 95%;
    margin: 20px auto;
    background: #ffffff;
    padding: 20px;
    border-radius: 15px;
    box-shadow: 0 0 15px rgba(0,0,0,0.1);
}

.wrapper h1 {
    text-align: center;
    color: #2c3e50;
    font-family: 'Poppins', sans-serif;
    font-size: 32px;
    margin-bottom: 20px;
}

.content-table {
    border-collapse: collapse;
    margin: 20px auto;
    font-size: 16px;
    width: 100%;
    border-radius: 12px 12px 0 0;
    overflow: hidden;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}

.content-table th {
    background-color: #4CAF50;
    color: white;
    text-align: center;
    font-weight: 600;
    padding: 12px 15px;
}

.content-table td {
    padding: 10px 15px;
    text-align: center;
    border-bottom: 1px solid #ddd;
}

.content-table tr:nth-child(even) {
    background-color: #f9f9f9;
}

.content-table tr:hover {
    background-color: #f1f1f1;
    transition: 0.3s;
}

/* Status label styles */
label {
    font-weight: 500;
    padding: 5px 10px;
    border-radius: 6px;
    display: inline-block;
}

label[style*='orange'] {
    background-color: rgba(255, 165, 0, 0.15);
}

label[style*='green'] {
    background-color: rgba(0, 128, 0, 0.15);
}

label[style*='red'] {
    background-color: rgba(255, 0, 0, 0.15);
}

.error {
    color: red;
    font-weight: bold;
    text-align: center;
    background-color: #ffe5e5;
    padding: 10px;
    border-radius: 10px;
}

/* Update button image */
.content-table img {
    width: 24px;
    height: 24px;
    transition: 0.3s ease-in-out;
}

.content-table img:hover {
    transform: scale(1.2);
}

/* Success message */
.success {
    color: green;
    font-weight: bold;
    background-color: #eaffea;
    padding: 10px;
    border-radius: 10px;
    text-align: center;
}

/* Responsive */
@media (max-width: 768px) {
    .content-table, .content-table thead, .content-table tbody, .content-table th, .content-table td, .content-table tr {
        display: block;
    }

    .content-table tr {
        margin-bottom: 15px;
        border-bottom: 2px solid #ddd;
    }

    .content-table td {
        text-align: right;
        padding-left: 50%;
        position: relative;
    }

    .content-table td::before {
        content: attr(data-label);
        position: absolute;
        left: 15px;
        width: 45%;
        text-align: left;
        font-weight: 600;
        color: #555;
    }

    .content-table th {
        display: none;
    }
}
</style>

<div class="wrapper">
    <h1>Manage Orders</h1>

    <br />

    <?php 
        if(isset($_SESSION['update']))
        {
            echo $_SESSION['update'];
            unset($_SESSION['update']);
        }
    ?>
    <br>

    <table class="content-table">
        <tr>
            <th>S.N.</th>
            <th>Food</th>
            <th>Price</th>
            <th>Qty.</th>
            <th>Total</th>
            <th>Order Date</th>
            <th>Status</th>
            <th>Customer Name</th>
            <th>Contact</th>
            <th>Email</th>
            <th>Address</th>
            <th>Update Orders</th>
        </tr>

        <?php 
            //Get all the orders from database
            $sql = "SELECT users.*, tbl_order.* FROM users INNER JOIN tbl_order ON users.id=tbl_order.u_id";
            $res = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($res);
            $sn = 1;

            if($count>0)
            {
                while($row=mysqli_fetch_assoc($res))
                {
                    $id = $row['id'];
                    $food = $row['food'];
                    $price = $row['price'];
                    $qty = $row['qty'];
                    $total = $row['total'];
                    $order_date = $row['order_date'];
                    $status = $row['status'];
                    $customer_name = $row['customer_name'];
                    $customer_contact = $row['customer_contact'];
                    $customer_email = $row['customer_email'];
                    $customer_address = $row['customer_address'];
                    ?>

                    <tr>
                        <td data-label="S.N."><?php echo $sn++; ?></td>
                        <td data-label="Food"><?php echo $food; ?></td>
                        <td data-label="Price"><?php echo $price; ?></td>
                        <td data-label="Qty"><?php echo $qty; ?></td>
                        <td data-label="Total"><?php echo $total; ?></td>
                        <td data-label="Order Date"><?php echo $order_date; ?></td>

                        <td data-label="Status">
                            <?php 
                                if($status=="Ordered")
                                    echo "<label>$status</label>";
                                elseif($status=="On Delivery")
                                    echo "<label style='color: orange;'>$status</label>";
                                elseif($status=="Delivered")
                                    echo "<label style='color: green;'>$status</label>";
                                elseif($status=="Cancelled")
                                    echo "<label style='color: red;'>$status</label>";
                            ?>
                        </td>

                        <td data-label="Customer Name"><?php echo $customer_name; ?></td>
                        <td data-label="Contact"><?php echo $customer_contact; ?></td>
                        <td data-label="Email"><?php echo $customer_email; ?></td>
                        <td data-label="Address"><?php echo $customer_address; ?></td>
                        <td data-label="Update Orders">
                            <a href="<?php echo SITEURL; ?>admin/update-order.php?id=<?php echo $id; ?>">
                                <img src="../images/icons/update.png" alt="Update">
                            </a>
                        </td>
                    </tr>

                    <?php
                }
            }
            else
            {
                echo "<tr><td colspan='12' class='error'>Orders not Available</td></tr>";
            }
        ?>
    </table>
</div>

<?php include('partials/footer.php'); ?>
