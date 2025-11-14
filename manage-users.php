<?php include('partials/menu.php'); ?>

<!-- Main Content Section Starts -->
<div class="main-content">
    <div class="wrapper">
        <h1>Manage Users</h1>
        <br />

        <?php 
        // Bootstrap alert for all session messages
        $session_messages = [
            'add' => 'success',
            'delete' => 'danger',
            'update' => 'info',
            'user-not-found' => 'warning',
            'pwd-not-match' => 'warning',
            'change-pwd' => 'success'
        ];

        foreach($session_messages as $session_key => $alert_type) {
            if(isset($_SESSION[$session_key])) {
                echo '<div class="alert alert-' . $alert_type . ' alert-dismissible fade show" role="alert">'
                        . $_SESSION[$session_key] .
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                         </button>
                      </div>';
                unset($_SESSION[$session_key]);
            }
        }
        ?>
        <br><br>

        <!-- Button to Add User -->
        <a href="add-users.php" class="btn-primary">Add User</a>
        <br /><br /><br />

        <table class="content-table">
            <tr>
                <th>S.N.</th>
                <th>Full Name</th>
                <th>Username</th>
                <th>Email</th>
                <th>Contact</th>
                <th>Address</th>
                <th>Created At</th>
                <th>Update User</th>
                <th>Delete User</th>
            </tr>

            <?php 
            // Query to get all users
            $sql = "SELECT * FROM users";
            $res = mysqli_query($conn, $sql);

            if($res == TRUE) {
                $count = mysqli_num_rows($res);
                $sn = 1;

                if($count > 0) {
                    while($rows = mysqli_fetch_assoc($res)) {
                        $id = $rows['id'];
                        $full_name = $rows['customer_name'];
                        $username = $rows['username'];
                        $email = $rows['customer_email'];
                        $contact = $rows['customer_contact'];
                        $address = $rows['customer_address'];
                        $created = $rows['created_at'];
                        ?>
                        <tr>
                            <td><?php echo $sn++; ?>.</td>
                            <td><?php echo $full_name; ?></td>
                            <td><?php echo $username; ?></td>
                            <td><?php echo $email; ?></td>
                            <td><?php echo $contact; ?></td>
                            <td><?php echo $address; ?></td>
                            <td><?php echo $created; ?></td>
                            <td>
                                <a href="<?php echo SITEURL; ?>admin/update-users.php?id=<?php echo $id; ?>">
                                    <img src="../images/icons/update-user.png"/>
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo SITEURL; ?>admin/delete-users.php?id=<?php echo $id; ?>" 
                                   onclick="return confirm('Are you sure you want to delete this user?');">
                                    <img src="../images/icons/delete-user.png"/>
                                </a>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    echo '<tr><td colspan="9" class="text-center">No Users Found.</td></tr>';
                }
            }
            ?>
        </table>
    </div>
</div>
<!-- Main Content Section Ends -->

<?php include('partials/footer.php'); ?>

<!-- Bootstrap JS (for alerts) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
