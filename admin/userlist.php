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
    <?php include('includes/header.php'); ?>
    <div class="ts-main-content">
        <?php include('includes/leftbar.php'); ?>
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="page-title">Manage Visitors</h2>
                        <div class="panel panel-default">
                            <div class="panel-heading">Add New User</div>
                        
                                <div class="form-group">
                                        <div class="col-sm-8 col-sm-offset-2">
                                            <a href="add-visitors.php"><button class="btn btn-primary" name="add" type="submit">Add Visitors</button></a>
                                        </div>
                                    </div>
    
                        </div>  


                      

                        <!-- Visitors List -->
                        <div class="panel panel-default">
                            <div class="panel-heading">Visitors List</div>
                            <div class="panel-body">
                            <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Location</th>
                                            <th>Reason</th>
                                            <th>Department</th>
                                            <th>File</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = "SELECT * FROM visitors";
                                        $query = $dbh->prepare($sql);
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                        $cnt = 1;
                                        if($query->rowCount() > 0) {
                                            foreach($results as $result) { ?>
                                                <tr>
                                                    <td><?php echo htmlentities($cnt); ?></td>
                                                    <td><?php echo htmlentities($result->visitor_name); ?></td>
                                                    <td><?php echo htmlentities($result->location); ?></td>
                                                    <td><?php echo htmlentities($result->reason); ?></td>
                                                    <td><?php echo htmlentities($result->department); ?></td>
                                                    <td><?php echo htmlentities($result->file); ?></td>
                                                    <td>
                                                        <a href="delete_visitor.php?del=<?php echo $result->id;?>" class="btn btn-danger" onclick="return confirm('Are you sure?');">Delete</a>
                                                    </td>
                                                </tr>
                                        <?php $cnt++; } } ?>
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
    <script src="js/main.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap.min.js"></script>
 
</body>
</html>
<?php } ?>
