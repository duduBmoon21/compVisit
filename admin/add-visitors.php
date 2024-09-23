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
        $location = $_POST['location'];
        $reason = $_POST['reason'];
        $department = $_POST['department'];
        $file = $_FILES['file']['name'];
        
        // Handling file upload
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($file);
        move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);

        // Insert visitor data into the database
        $sql = "INSERT INTO visitors (visitor_name, location, reason, department, file) 
                VALUES (:visitor_name, :location, :reason, :department, :file)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':visitor_name', $visitor_name, PDO::PARAM_STR);
        $query->bindParam(':location', $location, PDO::PARAM_STR);
        $query->bindParam(':reason', $reason, PDO::PARAM_STR);
        $query->bindParam(':department', $department, PDO::PARAM_STR);
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
                                    <form method="post" enctype="multipart/form-data" class="form-horizontal">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Visitor Name<span style="color:red">*</span></label>
                                            <div class="col-sm-4">
                                                <input type="text" name="visitor_name" class="form-control" required>
                                            </div>
                                            <label class="col-sm-2 control-label">Location<span style="color:red">*</span></label>
                                            <div class="col-sm-4">
                                                <input type="text" name="location" class="form-control" required>
                                            </div>
                                        </div>
    
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Reason for Visit<span style="color:red">*</span></label>
                                            <div class="col-sm-4">
                                                <input type="text" name="reason" class="form-control" required>
                                            </div>
                                            <label class="col-sm-2 control-label">Department<span style="color:red">*</span></label>
                                            <div class="col-sm-4">
                                                <select name="department" class="form-control" required>
                                                    <option value="">Select Department</option>
                                                    <option value="HR">HR</option>
                                                    <option value="IT">IT</option>
                                                    <option value="Finance">Finance</option>
                                                    <option value="Administration">Administration</option>
                                                </select>
                                            </div>
                                        </div>
    
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">File Upload (if necessary)</label>
                                            <div class="col-sm-4">
                                                <input type="file" name="file" class="form-control">
                                            </div>
                                        </div>
    
                                        <div class="form-group">
                                            <div class="col-sm-8 col-sm-offset-2">
                                                <button class="btn btn-primary" name="submit" type="submit">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <a href="userlist.php" class="block-anchor panel-footer">Go back  <i class="fa fa-arrow-left"></i></a>
                  
    
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
    
