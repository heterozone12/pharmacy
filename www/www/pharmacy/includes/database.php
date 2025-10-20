
<?php
    $servername = "mysql";
    $username = "root";
    $password = "root";
    $database_name = "pharmacyinventory_db";

    $conn = mysqli_connect($servername, $username, $password, $database_name);

    if(!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    } else {
        //echo "Connected successfully <br>";
    }
