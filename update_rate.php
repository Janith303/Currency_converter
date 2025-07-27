<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $code = $_POST['code'];
    $rate = $_POST['rate'];

    // Update the rate in the database
    $sql = "UPDATE rate SET rate_to_usd  = '$rate' WHERE currency_code = '$code'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert(' Rate for $code updated successfully to $rate'); window.location.href='update.php';</script>";
    } else {
        echo "<script>alert(' Error: " . $conn->error . "'); window.location.href='update.php';</script>";
    }
}
