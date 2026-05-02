<?php
session_start();
include 'db_connect.php'; // Agere code-e config.php chilo, sheta db_connect.php hobe

if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit();
}

$id = mysqli_real_escape_string($conn, $_GET['id']);
$result = mysqli_query($conn, "SELECT * FROM assignments WHERE id=$id"); // Table name assignments

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
} else {
    echo "Record not found!";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Assignment</title>
    <style>
        body { background: #1a1a1a; color: #fff; font-family: sans-serif; display: flex; justify-content: center; padding-top: 50px; }
        .edit-card { background: #111; padding: 30px; border-radius: 8px; border: 1px solid #D4AF37; width: 400px; }
        input, select { width: 100%; padding: 10px; margin: 10px 0; background: #222; border: 1px solid #333; color: #fff; }
        button { background: #D4AF37; color: #000; border: none; padding: 10px; width: 100%; font-weight: bold; cursor: pointer; }
    </style>
</head>
<body>
    <div class="edit-card">
        <h3>Update Assignment</h3>
        <form action="update.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            
            <label>Subject Name</label>
            <select name="subject_name">
                <option value="Software Dev III" <?php if($row['subject_name'] == 'Software Dev III') echo 'selected'; ?>>Software Dev III</option>
                <option value="Database Management" <?php if($row['subject_name'] == 'Database Management') echo 'selected'; ?>>Database Management</option>
            </select>

            <label>Status</label>
            <input type="text" name="status" value="<?php echo $row['status']; ?>">

            <button type="submit">Save Changes</button>
        </form>
    </div>
</body>
</html>