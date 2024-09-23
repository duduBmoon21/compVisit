<?php
session_start();

// Check if the user is logged in
if (isset($_SESSION['alogin'])) {
    // Assuming 'role_id' is stored in the session after the user logs in
    $role_id = $_SESSION['role_id']; 

    // Render the sidebar based on the user's role
    ?>
    <nav class="ts-sidebar"> 
        <ul class="ts-sidebar-menu">
            <li class="ts-label">Main</li>
            <li><a href="employee_dashboard.php"><i class="fa fa-user"></i> &nbsp;Dashboard</a></li>
            <li><a href="<?php echo ($role_id == 1) ? 'visitors.php' : 'emp/visitors.php'; ?>">
                <i class="fa fa-envelope"></i> &nbsp;Visitors</a></li>
            <li><a href="notification.php"><i class="fa fa-bell"></i> &nbsp;Notification<sup style="color:red">*</sup></a></li>
            <li><a href="messages.php"><i class="fa fa-envelope"></i> &nbsp;Messages</a></li>
            <li><a href="profile.php"><i class="fa fa-user"></i> &nbsp;Profile</a></li>
            <li><a href="feedback.php"><i class="fa fa-envelope"></i> &nbsp;Feedback</a></li>
            <li><a href=""><i class="fa fa-code" ><span style="color:red"></i> &nbsp;El's Code</a></span></li>
        </ul>
    </nav>
    <?php
} else {
    // If not logged in, redirect to login page
    header('Location: index.php');
    exit; // Always good practice to call exit after a redirect
}
?>
