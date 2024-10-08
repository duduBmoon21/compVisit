<?php
include('includes/config.php');

if(isset($_POST['submit'])) {
    $file = $_FILES['image']['name'];
    $file_loc = $_FILES['image']['tmp_name'];
    $folder = "images/"; 
    $new_file_name = strtolower($file);
    $final_file = str_replace(' ','-',$new_file_name);

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $gender = $_POST['gender'];
    $mobileno = $_POST['mobileno'];
    $designation = $_POST['designation'];
    $role_id = 1; // Default role ID

    if(move_uploaded_file($file_loc, $folder.$final_file)) {
        $image = $final_file;
    }

    $sql = "INSERT INTO users (name, email, password, gender, mobile, Location, image, role_id, status) 
            VALUES (:name, :email, :password, :gender, :mobileno, :designation, :image, :role_id, 1)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':name', $name, PDO::PARAM_STR);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':password', $password, PDO::PARAM_STR);
    $query->bindParam(':gender', $gender, PDO::PARAM_STR);
    $query->bindParam(':mobileno', $mobileno, PDO::PARAM_STR);
    $query->bindParam(':designation', $designation, PDO::PARAM_STR);
    $query->bindParam(':image', $image, PDO::PARAM_STR);
    $query->bindParam(':role_id', $role_id, PDO::PARAM_INT);
    
    if($query->execute()) {
        echo "<script>alert('Registration Successful');</script>";
        echo "<script>window.location.href='index.php'</script>";
    } else {
        $errorInfo = $query->errorInfo();
        echo "<script>alert('SQL Error: " . $errorInfo[2] . "');</script>";
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

    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-social.css">
    <link rel="stylesheet" href="css/bootstrap-select.css">
    <link rel="stylesheet" href="css/fileinput.min.css">
    <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
    <link rel="stylesheet" href="css/style.css">

    <script type="text/javascript">
        function validate() {
            var extensions = new Array("jpg", "jpeg");
            var image_file = document.regform.image.value;
            var image_length = document.regform.image.value.length;
            var pos = image_file.lastIndexOf('.') + 1;
            var ext = image_file.substring(pos, image_length);
            var final_ext = ext.toLowerCase();
            for (i = 0; i < extensions.length; i++) {
                if(extensions[i] == final_ext) {
                    return true;
                }
            }
            alert("Image Extension Not Valid (Use Jpg, jpeg)");
            return false;
        }
    </script>
</head>

<body>
    <div class="login-page bk-img">
        <div class="form-content">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="text-center text-bold mt-2x">Register</h1>
                        <div class="hr-dashed"></div>
                        <div class="well row pt-2x pb-3x bk-light text-center">
                            <form method="post" class="form-horizontal" enctype="multipart/form-data" name="regform" onSubmit="return validate();">
                                <div class="form-group">
                                    <label class="col-sm-1 control-label">Name<span style="color:red">*</span></label>
                                    <div class="col-sm-5">
                                        <input type="text" name="name" class="form-control" required>
                                    </div>
                                    <label class="col-sm-1 control-label">Email<span style="color:red">*</span></label>
                                    <div class="col-sm-5">
                                        <input type="text" name="email" class="form-control" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-1 control-label">Password<span style="color:red">*</span></label>
                                    <div class="col-sm-5">
                                        <input type="password" name="password" class="form-control" id="password" required>
                                    </div>

                                    <label class="col-sm-1 control-label">Designation<span style="color:red">*</span></label>
                                    <div class="col-sm-5">
                                        <input type="text" name="designation" class="form-control" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-1 control-label">Gender<span style="color:red">*</span></label>
                                    <div class="col-sm-5">
                                        <select name="gender" class="form-control" required>
                                            <option value="">Select</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>

                                    <label class="col-sm-1 control-label">Phone<span style="color:red">*</span></label>
                                    <div class="col-sm-5">
                                        <input type="number" name="mobileno" class="form-control" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-1 control-label">Avatar<span style="color:red">*</span></label>
                                    <div class="col-sm-5">
                                        <input type="file" name="image" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-offset-1 col-sm-10">
                                        <button class="btn btn-primary" name="submit" type="submit">Register</button>
                                    </div>
                                </div>
                            </form>
                            <br>
                            <p>Already Have an Account? <a href="index.php">Sign in</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Scripts -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap-select.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap.min.js"></script>
    <script src="js/Chart.min.js"></script>
    <script src="js/fileinput.js"></script>
    <script src="js/chartData.js"></script>
    <script src="js/main.js"></script>

</body>
</html>
