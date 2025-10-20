<?php
$conn = mysqli_connect('mysql','root','root','pharmacyinventory_db');
if (!$conn) { die('conn failed: '.mysqli_connect_error()); }
$low = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM medicines WHERE stock_quantity <= reorder_level"))['c'];
$today = date('Y-m-d');
$thirty = date('Y-m-d', strtotime('+30 days'));
$exp = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM medicines WHERE expiration_date BETWEEN '$today' AND '$thirty'"))['c'];
echo "low=$low exp=$exp\n";
?>