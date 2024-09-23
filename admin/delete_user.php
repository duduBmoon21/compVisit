<?php
session_start();
include('includes/config.php');

// Redirect to login if not logged in
if(strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {

    // Check if 'del' is set in GET request, i.e., a user deletion is requested
    if(isset($_GET['del'])) {
        $id = intval($_GET['del']); // Get the user's ID from the URL and ensure it is an integer
        
        // SQL query to delete the user from the admin table
        $sql = "DELETE FROM admin WHERE id = :id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();

        // Check if the user was successfully deleted
        if($query->rowCount() > 0) {
            $msg = "Admin deleted successfully!";
        } else {
            $error = "Failed to delete the admin.";
        }
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
    
    <title>Delete User</title>

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
            color: #fff;
            box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
        }
        .succWrap {
            padding: 10px;
            margin: 0 0 20px 0;
            background: #5cb85c;
            color: #fff;
            box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
        }
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
                        <h3 class="page-title">Delete Admin</h3>

                        <!-- Display success or error message -->
                        <?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
                              else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>

                        <!-- Admin List Panel -->
                        <div class="panel panel-default">
                            <div class="panel-heading">List of Admins</div>
                            <div class="panel-body">
                                <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Username</th>
                                            <th>Email</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        // Fetch admin users from the admin table
                                        $sql = "SELECT * FROM admin";
                                        $query = $dbh->prepare($sql);
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                        $cnt = 1;
                                        if($query->rowCount() > 0) {
                                            foreach($results as $result) { ?>	
                                                <tr>
                                                    <td><?php echo htmlentities($cnt); ?></td>
                                                    <td><?php echo htmlentities($result->username); ?></td>
                                                    <td><?php echo htmlentities($result->email); ?></td>
                                                    <td>
                                                        <a href="edit_admin.php?id=<?php echo htmlentities($result->id); ?>"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;
                                                        <a href="delete_user.php?del=<?php echo htmlentities($result->id); ?>" onclick="return confirm('Are you sure you want to delete this admin?');"><i class="fa fa-close"></i></a>
                                                    </td>
                                                </tr>
                                                <?php $cnt = $cnt + 1; 
                                            }
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Scripts -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>

<?php } ?>
