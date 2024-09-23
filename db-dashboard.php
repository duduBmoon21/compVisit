<?php 
session_start();
error_reporting(0);
include('includes/config.php');

if(strlen($_SESSION['alogin']) == 0) {	
    header('location:index.php');
} else {
    // Fetch gender distribution data
    $sql1 = "SELECT gender, COUNT(id) as gender_count FROM visitors GROUP BY gender";
    $query1 = $dbh->prepare($sql1);
    $query1->execute();
    $genderResults = $query1->fetchAll(PDO::FETCH_OBJ);

    // Fetch department-wise visitor count (show role name)
    $sql2 = "SELECT r.role_name, COUNT(v.id) as visitor_count 
             FROM visitors v 
             JOIN roles r ON v.department = r.role_id 
             GROUP BY r.role_name";
    $query2 = $dbh->prepare($sql2);
    $query2->execute();
    $departmentResults = $query2->fetchAll(PDO::FETCH_OBJ);

    // Prepare data for gender pie chart
    $genders = [];
    $genderCounts = [];
    foreach ($genderResults as $result) {
        array_push($genders, ucfirst($result->gender)); // Capitalize the gender name
        array_push($genderCounts, $result->gender_count);
    }

    // Prepare data for department (role name) pie chart
    $departments = [];
    $visitorCounts = [];
    foreach ($departmentResults as $result) {
        array_push($departments, $result->role_name); // Use role names instead of department numbers
        array_push($visitorCounts, $result->visitor_count);
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
    
    <title>Admin Dashboard</title>
    
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-social.css">
    <link rel="stylesheet" href="css/bootstrap-select.css">
    <link rel="stylesheet" href="css/fileinput.min.css">
    <link rel="stylesheet" href="css/style.css">

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
<?php include('includes/header.php'); ?>

    <div class="ts-main-content">
        <?php include('includes/leftbar.php'); ?>
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="page-title">Dc Dashboard</h2>

                        <div class="row">

                            <!-- Total Visitors -->
                            <div class="col-md-3">
                                <div class="panel panel-default">
                                    <div class="panel-body bk-success text-light">
                                        <div class="stat-panel text-center">
                                            <?php 
                                            $sql3 = "SELECT id FROM visitors";
                                            $query3 = $dbh->prepare($sql3);
                                            $query3->execute();
                                            $totalVisitors = $query3->rowCount();
                                            ?>
                                            <div class="stat-panel-number h1"><?php echo htmlentities($totalVisitors); ?></div>
                                            <div class="stat-panel-title text-uppercase">Total Visitors</div>
                                        </div>
                                    </div>
                                    <a href="visitordetails.php" class="block-anchor panel-footer">Full Detail <i class="fa fa-arrow-right"></i></a>
                                </div>
                            </div>

                            <!-- Pie Chart: Gender Distribution -->
                            <div class="col-md-6">
                                <div class="panel panel-default">
                                    <div class="panel-heading">Visitors by Gender</div>
                                    <div class="panel-body">
                                        <canvas id="genderChart" style="width: 150px;"></canvas> <!-- Smaller pie chart -->
                                    </div>
                                </div>
                            </div>

                            <!-- Pie Chart: Department-wise Visitor Distribution -->
                            <div class="col-md-6">
                                <div class="panel panel-default">
                                    <div class="panel-heading">Visitors by Department</div>
                                    <div class="panel-body">
                                        <canvas id="departmentChart" style="width: 150px;"></canvas> <!-- Smaller pie chart -->
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap-select.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap.min.js"></script>
    <script src="js/main.js"></script>

    <!-- Chart.js Scripts -->
    <script>
        // Gender Pie Chart
        var ctx1 = document.getElementById('genderChart').getContext('2d');
        var genderChart = new Chart(ctx1, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($genders); ?>,
                datasets: [{
                    data: <?php echo json_encode($genderCounts); ?>,
                    backgroundColor: ['#36a2eb', '#ff6384'], // Blue for Male, Red for Female
                    borderColor: ['#36a2eb', '#ff6384'],
                    borderWidth: 1
                }]
            }
        });

        // Department (Role Name) Pie Chart
        var ctx2 = document.getElementById('departmentChart').getContext('2d');
        var departmentChart = new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($departments); ?>, // Department names (role names)
                datasets: [{
                    data: <?php echo json_encode($visitorCounts); ?>,
                    backgroundColor: [
                        '#ff6384', '#36a2eb', '#ffce56', '#4bc0c0', '#9966ff', '#ff9f40'
                    ], // You can add more colors as needed
                    borderColor: [
                        '#ff6384', '#36a2eb', '#ffce56', '#4bc0c0', '#9966ff', '#ff9f40'
                    ],
                    borderWidth: 1
                }]
            }
        });
    </script>

</body>
</html>
<?php } ?>
