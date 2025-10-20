<?php
$conn = mysqli_connect('mysql','root','root','pharmacyinventory_db');
if (!$conn) die('conn err');
$thirty = date('Y-m-d', strtotime('+30 days'));
$res = mysqli_query($conn, "SELECT medicine_id, expiration_date FROM medicines");
while($r = mysqli_fetch_assoc($res)){
  $exp = $r['expiration_date'];
  $le = ($exp <= $thirty) ? 'yes' : 'no';
  echo $r['medicine_id']." exp=$exp le?=$le (thirty=$thirty)\n";
}
?>