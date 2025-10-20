<?php
$conn = mysqli_connect('mysql','root','root','pharmacyinventory_db');
if (!$conn) { die('conn failed: '.mysqli_connect_error()); }
$res = mysqli_query($conn, "SHOW TABLES");
while($r = mysqli_fetch_row($res)) { echo "TABLE: " . $r[0] . "\n"; }

$res = mysqli_query($conn, "SELECT COUNT(*) as c FROM medicines");
$row = mysqli_fetch_assoc($res);
echo "COUNT medicines = " . $row['c'] . "\n";

$res = mysqli_query($conn, "SELECT * FROM medicines LIMIT 5");
if ($res) {
  while($r = mysqli_fetch_assoc($res)) {
    echo json_encode($r) . "\n";
  }
} else {
  echo "SELECT failed: " . mysqli_error($conn) . "\n";
}
?>