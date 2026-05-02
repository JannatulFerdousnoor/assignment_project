<?php
session_start();
include 'db_connect.php'; // Database connection correct kora holo

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject_name']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    // Assignments table update kora holo
    $query = "UPDATE assignments SET subject_name='$subject', status='$status' WHERE id=$id";

    if (mysqli_query($conn, $query)) {
        header("Location: dashboard.php?msg=updated");
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}
?>