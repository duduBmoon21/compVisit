<?php
session_start();
error_reporting(0);
include('includes/config.php');

// Redirect if not logged in
if(strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    // Get user ID from URL
    $userId = intval($_GET['edit']);

    // Fetch user details based on ID
    $sql = "SELECT * FROM users01 WHERE id = :id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':id', $userId, PDO::PARAM_INT);
    $query->execute();
    $user = $query->fetch(PDO::FETCH_OBJ);

    // Handling form submission to update user details
    if(isset($_POST['submit'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $role = $_POST['role'];

        // If password is updated, hash the new password
        if(!empty($_POST['password'])) {
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $sql = "UPDATE users01 SET name = :name, email = :email, password = :password, role = :role WHERE id = :id";
            $query = $dbh->prepare($sql);
            $query->bindParam(':password', $password, PDO::PARAM_STR);
        } else {
            $sql = "UPDATE users01 SET name = :name, email = :email, role = :role WHERE id = :id";
            $query = $dbh->prepare($sql);
        }

        $query->bindParam(':name', $name, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':role', $role, PDO::PARAM_STR);
        $query->bindParam(':id', $userId, PDO::PARAM_INT);
        $query->execute();

        if($query->rowCount() > 0) {
            $msg = "User updated successfully!";
        } else {
            $error = "Something went wrong. Please try again.";
        }
    }
?>

<!doctype html>
<html lang="en" class="no-js">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Edit User</title>
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .errorWrap { background: #dd3d36; color: #fff; padding: 10px; margin: 20px 0; }
        .succWrap { background: #5cb85c; color: #fff; padding: 10px; margin: 20px 0; }
    </style>
</head>

<body>
    <?php include('includes/header.php'); ?>
    <div class="ts-main-content">
        <?php include('includes/leftbar.php'); ?>
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="page-title">Edit User</h3>
                        <div class="panel panel-default">
                            <div class="panel-heading">Edit User Info</div>
                            <?php if($error) { ?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?></div><?php } 
                            else if($msg) { ?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?></div><?php } ?>

                            <div class="panel-body">
                                <form method="post" class="form-horizontal">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Name<span style="color:red">*</span></label>
                                        <div class="col-sm-4">
                                            <input type="text" name="name" class="form-control" required value="<?php echo htmlentities($user->name); ?>">
                                        </div>
                                        <label class="col-sm-2 control-label">Email<span style="color:red">*</span></label>
                                        <div class="col-sm-4">
                                            <input type="email" name="email" class="form-control" required value="<?php echo htmlentities($user->email); ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Password</label>
                                        <div class="col-sm-4">
                                            <input type="password" name="password" class="form-control" placeholder="Leave blank if unchanged">
                                        </div>
                                        <label class="col-sm-2 control-label">Role<span style="color:red">*</span></label>
                                        <div class="col-sm-4">
                                            <select name="role" class="form-control" required>
                                                <option value="admin" <?php if($user->role == 'admin') echo 'selected'; ?>>Admin</option>
                                                <option value="employee" <?php if($user->role == 'employee') echo 'selected'; ?>>Employee</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-8 col-sm-offset-2">
                                            <button class="btn btn-primary" name="submit" type="submit">Save Changes</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>
<?php } ?>
