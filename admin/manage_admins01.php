<?php 
session_start();
error_reporting(0);
include('includes/config.php');

// Redirect to login if not logged in
if(strlen($_SESSION['alogin']) == 0) {	
    header('location:index.php');
} else {

    // Delete Admin
    if(isset($_GET['del'])) {
        $id = intval($_GET['del']);
        $sql = "DELETE FROM admin WHERE id = :id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();
        $msg = "Admin deleted successfully!";
    }


 // Add new admin
 if(isset($_POST['add'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = md5($_POST['password']); // Hash password using MD5
    
    // Insert new admin
    $sql = "INSERT INTO admin (username, email, password) VALUES (:name, :email, :password)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':name', $name, PDO::PARAM_STR);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':password', $password, PDO::PARAM_STR);
    $query->execute();
    $msg = "New Admin Added Successfully";
    $_POST = array();
}

// Edit existing admin
if(isset($_POST['submit'])) {	
    $name = $_POST['name'];
    $email = $_POST['email'];
    $id = $_POST['id']; // Get the admin ID to update

    // Update admin information
    $sql = "UPDATE admin SET username = :name, email = :email WHERE id = :id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':name', $name, PDO::PARAM_STR);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->execute();
    $msg = "Admin Information Updated Successfully";
}

// Fetch all admins
$sql = "SELECT * FROM admin";
$query = $dbh->prepare($sql);
$query->execute();
$admins = $query->fetchAll(PDO::FETCH_OBJ);



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
    
    <title>Manage Admins</title>

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
                        <h3 class="page-title">Manage Admins</h3>
                        <div class="panel panel-default">
                            <div class="panel-heading">Add New Admin</div>
                         
                             
                                <div class="form-group">
                                        <div class="col-sm-8 col-sm-offset-2">
                                            <a href="add-admin.php"><button class="btn btn-primary" name="add" type="submit">Add Emplyee</button></a>
                                        </div>
                                    </div>

                         
                        </div>
                        <!-- Admin List Panel -->
                        <div class="panel panel-default">
                            <div class="panel-heading">List of Admins</div>
                            <div class="panel-body">
                            <?php if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
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
                                         $cnt=1;
                                         if($admins) {
                                            foreach($admins as $admin) { ?>	
                                                <tr>
                                                <td><?php echo htmlentities($cnt);?></td>
                                                    <td><?php echo htmlentities($admin->username);?></td>
                                                    <td><?php echo htmlentities($admin->email);?></td>
                                                    <td>
                                                        <a  href="edit-admin.php?id=<?php echo $admin->id;?>"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;
                                                        <a href="manage_admins01.php?del=<?php echo $admin->id;?>"><i class="fa fa-close"></i></a>
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
