<?php 
session_start();
include('includes/config.php');

if (isset($_POST['login'])) {
    $email = $_POST['username'];
    $password = md5($_POST['password']);
    
    // Debugging: Print hashed password to check if it's correct
    // echo $password;
    
    // Query to fetch email, password, and role from user01 table
    $sql = "SELECT email, password, role FROM users01 WHERE email = :email AND password = :password";
    $query = $dbh->prepare($sql);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':password', $password, PDO::PARAM_STR);
    $query->execute();
    
    $results = $query->fetch(PDO::FETCH_OBJ);
    
    if ($results) {
        // Store user email and role in session
        $_SESSION['login'] = $results->email; // Correct case-sensitive access
        $_SESSION['role'] = $results->role;   // Correct case-sensitive access
        
        // Redirect based on user role
        if ($results->role == 'admin') {
            header("Location: admin_dashboard.php");
        } else if ($results->role == 'employee') {
            header("Location: employee_dashboard.php");
        } else {
            // Handle other roles if necessary
            echo "<script>alert('Unauthorized role');</script>";
        }
        exit();
    } else {
        echo "<script>alert('Invalid Details');</script>";
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
</head>

<body>
    <div class="login-page bk-img" style="background-image: url(img/background.jpg);">
        <div class="form-content">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <h1 class="text-center text-bold mt-4x">User Login</h1>
                        <div class="well row pt-2x pb-3x bk-light">
                            <div class="col-md-8 col-md-offset-2">
                                <form method="post">
                                    <label for="" class="text-uppercase text-sm">Your Email</label>
                                    <input type="text" placeholder="Email" name="username" class="form-control mb" required>

                                    <label for="" class="text-uppercase text-sm">Password</label>
                                    <input type="password" placeholder="Password" name="password" class="form-control mb" required>
                                    <button class="btn btn-primary btn-block" name="login" type="submit">LOGIN</button>
                                </form>
                            </div>
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
s