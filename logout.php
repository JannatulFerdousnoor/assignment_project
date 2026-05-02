<?php
session_start();
session_destroy(); // Session muche fele
header("Location: index.php"); // Login page-e niye jay
exit();
?>