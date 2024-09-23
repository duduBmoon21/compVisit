<?php 
session_start();
error_reporting(0);
include('includes/config.php');

// Redirect to login if not logged in
if(strlen($_SESSION['alogin']) == 0) {	
    header('location:index.php');
} else {

    // Delete Role
    if(isset($_GET['del'])) {
        $id = intval($_GET['del']);
        $sql = "DELETE FROM roles WHERE id = :id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();
        $msg = "Role deleted successfully!";
    }

    // Add new role
    if(isset($_POST['add'])) {
        $role_name = $_POST['role_name'];

        // Insert new role
        $sql = "INSERT INTO roles (role_name) VALUES (:role_name)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':role_name', $role_name, PDO::PARAM_STR);
        $query->execute();
        $msg = "New Role Added Successfully";
        $_POST = array();
    }

    // Edit existing role
    if(isset($_POST['submit'])) {	
        $role_name = $_POST['role_name'];
        $id = $_POST['id']; // Get the role ID to update

        // Update role information
        $sql = "UPDATE roles SET role_name = :role_name WHERE id = :id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':role_name', $role_name, PDO::PARAM_STR);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();
        $msg = "Role Information Updated Successfully";
    }

    // Fetch all roles
    $sql = "SELECT * FROM roles";
    $query = $dbh->prepare($sql);
    $query->execute();
    $roles = $query->fetchAll(PDO::FETCH_OBJ);
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
    
    <title>Manage Roles</title>

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
                        <h3 class="page-title">Manage Roles</h3>
                        <div class="panel panel-default">
                            <div class="panel-heading">Add New Role</div>
                            <div class="panel-body">
                               
                                <div class="form-group">
                                        <div class="col-sm-8 col-sm-offset-2">
                                            <a href="role.php"><button class="btn btn-primary" name="add" type="submit">Add role</button></a>
                                        </div>
                                    </div>
                               
                            </div>
                        </div>

                        <!-- Roles List Panel -->
                        <div class="panel panel-default">
                            <div class="panel-heading">List of Roles</div>
                            <div class="panel-body">
                                <?php if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
                                <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Role Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                         $cnt=1;
                                         if($roles) {
                                            foreach($roles as $role) { ?>	
                                                <tr>
                                                    <td><?php echo htmlentities($cnt);?></td>
                                                    <td><?php echo htmlentities($role->role_name);?></td>
                                                    <td>
                                                    <a href="edit-role.php?edit=<?php echo $result->id;?>" onclick="return confirm('Do you want to Edit');">&nbsp; <i class="fa fa-pencil"></i></a>&nbsp;&nbsp;
<a href="role01.php?del=<?php echo $result->id;?>&name=<?php echo htmlentities($result->email);?>" onclick="return confirm('Do you want to Delete');"><i class="fa fa-trash" style="color:red"></i></a>&nbsp;&nbsp;

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
