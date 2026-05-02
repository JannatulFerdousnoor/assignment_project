<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "assignment_system";

// mysqli_query bad diye ekhane mysqli_connect hobe
$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>