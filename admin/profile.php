<?php 
session_start();
error_reporting(0);
include('includes/config.php');

if(strlen($_SESSION['alogin']) == 0) {    
    header('location:index.php');
} else {

    if(isset($_POST['submit'])) {
        // Get the uploaded file details
        $file = $_FILES['image']['name'];
        $file_loc = $_FILES['image']['tmp_name'];
        $folder = "../images/";
        $new_file_name = strtolower($file);
        $final_file = str_replace(' ', '-', $new_file_name);

        // Collecting the form input data
        $name = $_POST['name'];
        $email = $_POST['email'];
        $gender = $_POST['gender'];
        $mobileno = $_POST['mobileno'];
        $designation = $_POST['designation'];
        $password = md5($_POST['password']); // Hash the password
        $role_id = isset($_POST['role']) ? $_POST['role'] : 1; // Default to role_id 1 if not provided

        // Move uploaded file to the desired location
        if(move_uploaded_file($file_loc, $folder . $final_file)) {
            $image = $final_file;
        } else {
            $image = ""; // Set to empty if no file was uploaded
        }

        // Insert user information into the database
        $sql = "INSERT INTO users (name, email, password, gender, mobile, Location, image, role_id) 
                VALUES (:name, :email, :password, :gender, :mobileno, :designation, :image, :role_id)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':name', $name, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':password', $password, PDO::PARAM_STR); // Bind hashed password
        $query->bindParam(':gender', $gender, PDO::PARAM_STR);
        $query->bindParam(':mobileno', $mobileno, PDO::PARAM_STR);
        $query->bindParam(':designation', $designation, PDO::PARAM_STR);
        $query->bindParam(':image', $image, PDO::PARAM_STR);
        $query->bindParam(':role_id', $role_id, PDO::PARAM_INT); // Bind role_id as integer
        $query->execute();

        $msg = "User Added Successfully!";
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
    
    <title>Add New User</title>

    <!-- Font awesome -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <!-- Sandstone Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Admin Style -->
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
    <?php include('includes/header.php');?>
    <div class="ts-main-content">
        <?php include('includes/leftbar.php');?>
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="page-title">Add New User</h3>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">User Info</div>
                                    <?php if($msg){?><div class="succWrap"><strong>SUCCESS</strong>: <?php echo htmlentities($msg); ?> </div><?php }?>

                                    <div class="panel-body">
                                        <form method="post" class="form-horizontal" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Name<span style="color:red">*</span></label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="name" class="form-control" required>
                                                </div>
                                                <label class="col-sm-2 control-label">Email<span style="color:red">*</span></label>
                                                <div class="col-sm-4">
                                                    <input type="email" name="email" class="form-control" required>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Password<span style="color:red">*</span></label>
                                                <div class="col-sm-4">
                                                    <input type="password" name="password" class="form-control" required>
                                                </div>
                                                <label class="col-sm-2 control-label">Gender<span style="color:red">*</span></label>
                                                <div class="col-sm-4">
                                                    <select name="gender" class="form-control" required>
                                                        <option value="">Select</option>
                                                        <option value="Male">Male</option>
                                                        <option value="Female">Female</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Mobile No.<span style="color:red">*</span></label>
                                                <div class="col-sm-4">
                                                    <input type="number" name="mobileno" class="form-control" required>
                                                </div>
                                                <label class="col-sm-2 control-label">Location<span style="color:red">*</span></label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="designation" class="form-control" required>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Image<span style="color:red">*</span></label>
                                                <div class="col-sm-4">
                                                    <input type="file" name="image" class="form-control" required>
                                                </div>
                                                <label class="col-sm-2 control-label">Role<span style="color:red">*</span></label>
                                                <div class="col-sm-4">
                                                    <select name="role" class="form-control" required>
                                                        <option value="">Select Role</option>
                                                        <?php 
                                                            // Fetch roles from database
                                                            $sql = "SELECT role_id, role_name FROM roles";
                                                            $query = $dbh->prepare($sql);
                                                            $query->execute();
                                                            $roles = $query->fetchAll(PDO::FETCH_ASSOC);
                                                            foreach($roles as $role) {
                                                                echo "<option value='".$role['role_id']."'>".$role['role_name']."</option>";
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-sm-8 col-sm-offset-2">
                                                    <button class="btn btn-primary" name="submit" type="submit">Add User</button>
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
        </div>
    </div>

    <!-- Loading Scripts -->
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
