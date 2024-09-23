<?php 
session_start();
error_reporting(0);
include('includes/config.php');

// Redirect to login if not logged in
if(strlen($_SESSION['alogin']) == 0) {	
    header('location:index.php');
} else {

    // Get the admin ID from the URL
    $id = intval($_GET['id']);
    
    // Fetch the admin's current details
    $sql = "SELECT * FROM admin WHERE id = :id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_OBJ);

    // Update the admin details
    if(isset($_POST['submit'])) {	
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        // Only update the password if a new one is provided
        if(!empty($password)) {
            $hashed_password = md5($password);
            $sql = "UPDATE admin SET username = :name, email = :email, password = :password WHERE id = :id";
            $query = $dbh->prepare($sql);
            $query->bindParam(':password', $hashed_password, PDO::PARAM_STR);
        } else {
            $sql = "UPDATE admin SET username = :name, email = :email WHERE id = :id";
            $query = $dbh->prepare($sql);
        }

        $query->bindParam(':name', $name, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();
        
        $msg = "Admin Details Updated Successfully";
    }
?>

<!doctype html>
<html lang="en" class="no-js">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="theme-color" content="#3e454c">
    
    <title>Edit Admin</title>

    <!-- Stylesheets -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">

    <style>
        .errorWrap {
            padding: 10px;
            margin: 0 0 20px 0;
            background: #dd3d36;
            color:#fff;
            box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
        }
        .succWrap {
            padding: 10px;
            margin: 0 0 20px 0;
            background: #5cb85c;
            color:#fff;
            box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
        }
    </style>
</head>

<body>
    <?php include('includes/header.php');?>
    <div class="ts-main-content">
        <?php include('includes/leftbar.php');?>
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="page-title">Edit Admin</h3>
                        
                        <div class="panel panel-default">
                            <div class="panel-heading">Edit Admin Details</div>
                            <div class="panel-body">
                                <?php if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
                                <form method="post" class="form-horizontal" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Username<span style="color:red">*</span></label>
                                        <div class="col-sm-4">
                                            <input type="text" name="name" class="form-control" required value="<?php echo htmlentities($result->username);?>">
                                        </div>

                                        <label class="col-sm-2 control-label">Email<span style="color:red">*</span></label>
                                        <div class="col-sm-4">
                                            <input type="email" name="email" class="form-control" required value="<?php echo htmlentities($result->email);?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Password</label>
                                        <div class="col-sm-4">
                                            <input type="password" name="password" class="form-control" placeholder="Leave blank to keep current password">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-8 col-sm-offset-2">
                                            <button class="btn btn-primary" name="submit" type="submit">Update Admin</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <a href="manage_admins01.php" class="block-anchor panel-footer">Go back to manage <i class="fa fa-arrow-left"></i></a>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Scripts -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>

<?php } ?>
