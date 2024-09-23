<?php 
session_start();
error_reporting(0);
include('includes/config.php');

if(strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {

    // Handle form submission to add a new visitor
    if(isset($_POST['submit'])) {
        $visitor_name = $_POST['visitor_name'];
        $gender = $_POST['gender'];
        $phone_no = $_POST['phone_no'];
        $address = $_POST['address'];
        $reason = $_POST['reason'];
        $department = $_POST['department'];
        $file = $_FILES['file']['name'];
        
        // Handling file upload
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($file);
        move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);

        // Insert visitor data into the database
        $sql = "INSERT INTO visitors (visitor_name, gender, phone_no, address, reason, department, file) 
                VALUES (:visitor_name, :gender, :phone_no, :address, :reason, :department, :file)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':visitor_name', $visitor_name, PDO::PARAM_STR);
        $query->bindParam(':gender', $gender, PDO::PARAM_STR);
        $query->bindParam(':phone_no', $phone_no, PDO::PARAM_STR);
        $query->bindParam(':address', $address, PDO::PARAM_STR);
        $query->bindParam(':reason', $reason, PDO::PARAM_STR);
        $query->bindParam(':department', $department, PDO::PARAM_INT);
        $query->bindParam(':file', $file, PDO::PARAM_STR);
        $query->execute();

        if($query->rowCount() > 0) {
            $msg = "Visitor details added successfully!";
        } else {
            $error = "Something went wrong. Please try again.";
        }
    }

    // Delete visitor functionality
    if(isset($_GET['del'])) {
        $id = $_GET['del'];
        $sql = "DELETE FROM visitors WHERE id=:id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_STR);
        $query->execute();
        $msg = "Visitor record deleted successfully!";
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
        <title>Manage Visitors</title>
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <?php include('includes/header.php'); ?>
        <div class="ts-main-content">
            <?php include('includes/leftbar.php'); ?>
            <div class="content-wrapper">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="page-title">Manage Visitors</h2>
                            <div class="panel panel-default">
                                <div class="panel-heading">Visitor Information</div>
                                <?php if($error) { ?>
                                    <div class="errorWrap"><strong>ERROR</strong>: <?php echo htmlentities($error); ?></div>
                                <?php } else if($msg) { ?>
                                    <div class="succWrap"><strong>SUCCESS</strong>: <?php echo htmlentities($msg); ?></div>
                                <?php } ?>
                                <div class="panel-body">
                                <form method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label>Visitor Name<span style="color:red">*</span></label>
                                        <input type="text" name="visitor_name" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Gender<span style="color:red">*</span></label>
                                        <select name="gender" class="form-control" required>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                          
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Phone Number<span style="color:red">*</span></label>
                                        <input type="number" name="phone_no" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Address<span style="color:red">*</span></label>
                                        <textarea name="address" class="form-control" required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Where To <span style="color:red">*</span></label>
                                        <select name="department" class="form-control" required>
                                            <?php
                                            $sql = "SELECT * FROM roles";
                                            $query = $dbh->prepare($sql);
                                            $query->execute();
                                            $departments = $query->fetchAll(PDO::FETCH_ASSOC);
                                            foreach ($departments as $dept) {
                                                echo "<option value='{$dept['role_id']}'>{$dept['role_name']}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Reason for Visit<span style="color:red">*</span></label>
                                        <textarea name="reason" class="form-control" required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>File Upload </label>
                                        <input type="file" name="file" class="form-control">
                                    </div>
                                    <button type="submit" name="submit" class="btn btn-primary">Add Visitor</button>
                                </form>
                            </div>
                            </div>
                            <a href="visitors.php" class="block-anchor panel-footer">Go back  <i class="fa fa-arrow-left"></i></a>
                  
    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <!-- Loading Scripts -->
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/main.js"></script>
    </body>
    </html>
    <?php } ?>
    
