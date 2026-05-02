<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {

    $file_name = $_FILES['file']['name'];
    $file_tmp = $_FILES['file']['tmp_name'];

    $target_dir = "uploads/";

    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    // Clean file name
    $clean_name = time() . "_" . preg_replace("/[^a-zA-Z0-9.]/", "_", $file_name);
    $target_file = $target_dir . $clean_name;

    // File type check (important)
    $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $allowed = ['pdf', 'doc', 'docx', 'png', 'jpg'];

    if (!in_array($file_type, $allowed)) {
        echo "Only PDF, DOC, Image allowed!";
        exit();
    }

    if (move_uploaded_file($file_tmp, $target_file)) {

        // temporary static (later dynamic korbo)
        $assignment_id = 1;
        $student_id = 1;

        $sql = "INSERT INTO submissions (assignment_id, student_id, file_path, status) 
                VALUES ('$assignment_id', '$student_id', '$target_file', 'submitted')";

        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Submitted Successfully!'); window.location='dashboard.php';</script>";
        } else {
            echo "DB Error: " . mysqli_error($conn);
        }

    } else {
        echo "Upload failed!";
    }
}
?>