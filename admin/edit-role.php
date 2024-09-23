<?php
session_start();
error_reporting(0);
include('includes/config.php');

if(strlen($_SESSION['alogin']) == 0) {	
    header('location:index.php');
} else {
    // Adding a new role
    if(isset($_POST['add_role'])) {
        $role_name = $_POST['role_name'];

        if (empty($role_name)) {
            $error = "Role name cannot be empty!";
        } else {
            $sql = "INSERT INTO roles (role_name) VALUES (:role_name)";
            $query = $dbh->prepare($sql);
            $query->bindParam(':role_name', $role_name, PDO::PARAM_STR);
            $query->execute();

            if($query->rowCount() > 0) {
                $msg = "Role Added Successfully!";
            } else {
                $error = "Something went wrong. Please try again.";
            }
        }
    }

    // Editing a role
    if(isset($_POST['edit_role'])) {
        $role_id = $_POST['role_id'];
        $role_name = $_POST['role_name'];

        if (empty($role_name)) {
            $error = "Role name cannot be empty!";
        } else {
            $sql = "UPDATE roles SET role_name = :role_name WHERE role_id = :role_id";
            $query = $dbh->prepare($sql);
            $query->bindParam(':role_name', $role_name, PDO::PARAM_STR);
            $query->bindParam(':role_id', $role_id, PDO::PARAM_INT);
            $query->execute();

            if($query->rowCount() > 0) {
                $msg = "Role Updated Successfully!";
            } else {
                $error = "Something went wrong. Please try again.";
            }
        }
    }

    // Deleting a role
    if(isset($_GET['delete'])) {
        $role_id = $_GET['delete'];
        $sql = "DELETE FROM roles WHERE role_id = :role_id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':role_id', $role_id, PDO::PARAM_INT);
        $query->execute();

        if($query->rowCount() > 0) {
            $msg = "Role Deleted Successfully!";
        } else {
            $error = "Something went wrong. Please try again.";
        }
    }

    // Fetching roles for displaying
    $sql = "SELECT * FROM roles";
    $query = $dbh->prepare($sql);
    $query->execute();
    $roles = $query->fetchAll(PDO::FETCH_ASSOC);
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

    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
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
                        <h3 class="page-title">Manage Roles</h3>
                        <div class="row">
                        <?php
		$sql = "SELECT * from roles where id = :editid";
		$query = $dbh -> prepare($sql);
		$query->bindParam(':editid',$editid,PDO::PARAM_INT);
		$query->execute();
		$result=$query->fetch(PDO::FETCH_OBJ);
		$cnt=1;	
?>
                            <div class="col-md-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">Role Information</div>
                                    <?php if($error){ ?>
                                        <div class="errorWrap"><strong>ERROR</strong>: <?php echo htmlentities($error); ?> </div>
                                    <?php } else if($msg){ ?>
                                        <div class="succWrap"><strong>SUCCESS</strong>: <?php echo htmlentities($msg); ?> </div>
                                    <?php } ?>

                                    <div class="panel-body">
                                        <form method="post" class="form-horizontal">
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Role Name<span style="color:red">*</span></label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="role_name" class="form-control" required value="<?php echo htmlentities($result->name);?>">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-sm-8 col-sm-offset-2">
                                                    <button class="btn btn-primary" name="add_role" type="submit">update Role</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <a href="role01.php" class="block-anchor panel-footer">Go back <i class="fa fa-arrow-left"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {          
            setTimeout(function() {
                $('.succWrap').slideUp("slow");
            }, 3000);
        });
    </script>

</body>
</html>
<?php } ?>
