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
                            <div class="panel-heading">Add New Visitor</div>
                            <a href="add-visitors.php" class="block-anchor panel-footer"> <button type="submit" name="submit" class="btn btn-primary">Add Visitor</button></a>
                        </div>

                        <!-- Visitors List -->
                        <div class="panel panel-default">
                            <div class="panel-heading">Visitors List</div>
                            <div class="panel-body">
                <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Visitor Name</th>
                            <th>Gender</th>
                            <th>Phone No</th>
                            <th>Address</th>
                            <th>Reason</th>
                            <th>Department</th>
                            <th>Status</th>
                            <th>Created Date</th>
                            <th>Actions</th> <!-- Added this for Edit/Delete -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT v.*, r.role_name FROM visitors v JOIN roles r ON v.department = r.role_id ORDER BY v.created_at DESC";
                        $query = $dbh->prepare($sql);
                        $query->execute();
                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                        $cnt = 1;
                        foreach ($results as $result) {
                        ?>
                            <tr>
                                <td><?php echo htmlentities($cnt); ?></td>
                                <td><?php echo htmlentities($result->visitor_name); ?></td>
                                <td><?php echo htmlentities($result->gender); ?></td>
                                <td><?php echo htmlentities($result->phone_no); ?></td>
                                <td><?php echo htmlentities($result->address); ?></td>
                                <td><?php echo htmlentities($result->reason); ?></td>
                                <td><?php echo htmlentities($result->role_name); ?></td>
                                <td><?php echo htmlentities($result->status); ?></td>
                                <td><?php echo htmlentities($result->created_at); ?></td>
                                <td>
                                    <!-- Edit Button -->
                                    <a href="edit-visitors.php?id=<?php echo $result->id;?>" class="btn btn-info btn-sm">Edit</a>
                                    <!-- Delete Button -->
                                    <a href="manage_visitors.php?del=<?php echo $result->id;?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete?');">Delete</a>
                                </td>
                            </tr>
                        <?php $cnt++; } ?>
                    </tbody>
                </table>
                            </div>
                </div>>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Scripts -->
    <script src="js/main.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap.min.js"></script>
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
