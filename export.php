<?php
include_once 'db.php';
$conn = new mysqli($servername, $username, $password, $databasename);
if($conn->connect_error) {
    echo "Could not connect to database.";
    die();
}

$email_ids = $_POST["selected"] ?? null;
if($email_ids == null || count($email_ids) == 0) {
    die("ERROR: No data selected!");
}
$email_ids_str = "";
for($i = 1; $i < count($email_ids); ++$i) {
    $email_ids_str = $email_ids_str . $email_ids[$i] . ',';
}
$email_ids_str = $email_ids_str . $email_ids[0]; // No comma after last id

// Handle delete requests
$delete = $_POST["delete"] ?? null;
if($delete != null) {
    $sql = "DELETE FROM $tablename WHERE id IN ($email_ids_str);";
    if($conn->query($sql)) {
        // If deleting, redirect back to admin.php
        $conn->close();
        header("Location: admin.php");
        die();
    } else {
        $conn->close();
        die("Error executing SQL: $sql");
    }
}

// Handle exporting data to CSV
$export = $_POST["export"] ?? null;
if($export != null) {
    $sql = "SELECT email, timestamp FROM $tablename WHERE id IN ($email_ids_str);";
    if($result = $conn->query($sql)) {
        $f = fopen('php://memory','w');
        $title = array('EMAIL','TIMESTAMP');
        fputcsv($f, $title, ',');
        while($row = $result->fetch_assoc()) {
            $data = array($row['email'],$row['timestamp']);
            fputcsv($f, $data, ',');
        }

        fseek($f, 0);
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="email_data.csv";');

        fpassthru($f);
    } else {
        $conn->close();
        die("SQL error!");
    }
}

$conn->close();