<?php
session_start();
include('includes/config.php');

if (isset($_POST['login'])) {
    $status = '1'; // Only consider active users
    $email = $_POST['username'];
    $password = md5($_POST['password']); // Hashing the password

    // SQL query to fetch user details along with role_id
    $sql = "SELECT id, email, role_id FROM users WHERE email = :email AND password = :password AND status = :status";
    $query = $dbh->prepare($sql);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':password', $password, PDO::PARAM_STR);
    $query->bindParam(':status', $status, PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_OBJ);

    // Check if a valid user is found
    if ($result) {
        // Store user session details
        $_SESSION['alogin'] = $result->email;
        $_SESSION['user_id'] = $result->id;
        $_SESSION['role_id'] = $result->role_id;

        // Redirect based on role_id
        if ($result->role_id == 1) {
            header('Location: db-dashboard.php');
        } else {
            header('Location: emp/employee_dashboard.php');
        }
        exit; // Always good practice to call exit after a redirect
    } else {
        echo "<script>alert('Invalid Details Or Account Not Confirmed');</script>";
    }
}
?>

<!doctype html>
<html lang="en" class="no-js">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="login-page bk-img">
        <div class="form-content">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <h1 class="text-center text-bold mt-4x">vm Login</h1>
                        <div class="well row pt-2x pb-3x bk-light">
                            <div class="col-md-8 col-md-offset-2">
                                <form method="post">
                                    <label for="username" class="text-uppercase text-sm">Your Email</label>
                                    <input type="text" placeholder="Username" name="username" class="form-control mb" required>

                                    <label for="password" class="text-uppercase text-sm">Password</label>
                                    <input type="password" placeholder="Password" name="password" class="form-control mb" required>

                                    <button class="btn btn-primary btn-block" name="login" type="submit">LOGIN</button>
                                </form>
                                <br>
                                <p>Don't Have an Account? <a href="register.php">Signup</a></p>
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
</body>
</html>
