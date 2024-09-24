<?php
session_start();
include('includes/config.php');

header("Content-Type: application/xls");
header("Content-Disposition: attachment; filename=visitor_report.xlsx");
header("Pragma: no-cache");
header("Expires: 0");

$output = "";
$output .= "
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Visitor Name</th>
                <th>Location</th>
                <th>Reason</th>
                <th>Department</th>
                <th>Created Date</th>
            </tr>
        </thead>
        <tbody>
";

$sql = "SELECT * FROM visitors ORDER BY created_at DESC";
$query = $dbh->prepare($sql);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);
$cnt = 1;

foreach ($results as $result) {
    $output .= "
        <tr>
            <td>{$cnt}</td>
            <td>{$result->visitor_name}</td>
            <td>{$result->location}</td>
            <td>{$result->reason}</td>
            <td>{$result->department}</td>
            <td>{$result->created_at}</td>
        </tr>
    ";
    $cnt++;
}

$output .= "
        </tbody>
    </table>
";

echo $output;
?>
