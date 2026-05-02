<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];

// --- BACKEND LOGIC: Submission Handling ---
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['assignment_file'])) {
    $subject = mysqli_real_escape_string($conn, $_POST['subject_name']);
    $file = $_FILES['assignment_file'];
    
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) { mkdir($target_dir, 0777, true); }

    $file_ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $clean_name = time() . "_" . $user_id . "." . $file_ext;
    $target_file = $target_dir . $clean_name;

    if (move_uploaded_file($file['tmp_name'], $target_file)) {
        // Status default 'Submitted' thakbe
        $sql = "INSERT INTO assignments (user_id, subject_name, file_name, status) 
                VALUES ('$user_id', '$subject', '$clean_name', 'Submitted')";
        
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Assignment Submitted!'); window.location='dashboard.php';</script>";
        }
    }
}

// --- BACKEND LOGIC: Delete Handling ---
if (isset($_GET['delete_id'])) {
    $delete_id = mysqli_real_escape_string($conn, $_GET['delete_id']);
    mysqli_query($conn, "DELETE FROM assignments WHERE id = '$delete_id' AND user_id = '$user_id'");
    header("Location: dashboard.php");
}

// --- STATS CALCULATION ---
// Total Submissions
$count_res = mysqli_query($conn, "SELECT COUNT(*) as total FROM assignments WHERE user_id = '$user_id'");
$total_sub = mysqli_fetch_assoc($count_res)['total'];

// Pending Feedback (Jader grade ba feedback ekhono deya hoyni)
$pending_res = mysqli_query($conn, "SELECT COUNT(*) as pending FROM assignments WHERE user_id = '$user_id' AND (grade IS NULL OR feedback IS NULL)");
$pending_feedback = mysqli_fetch_assoc($pending_res)['pending'];

// Latest Grade (Average grade-er poriborte latest grade dekhano)
$grade_res = mysqli_query($conn, "SELECT grade FROM assignments WHERE user_id = '$user_id' AND grade IS NOT NULL ORDER BY id DESC LIMIT 1");
$latest_grade = mysqli_num_rows($grade_res) > 0 ? mysqli_fetch_assoc($grade_res)['grade'] : "N/A";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Elegance Portal | Pro Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root { --gold: #D4AF37; --dark: #0f0f0f; --card: #1a1a1a; --text: #e0e0e0; }
        body { margin: 0; font-family: 'Segoe UI', sans-serif; background: var(--dark); color: var(--text); display: flex; }
        .sidebar { width: 250px; height: 100vh; background: #000; border-right: 1px solid #333; position: fixed; padding: 20px; }
        .sidebar h2 { color: var(--gold); font-family: 'Playfair Display', serif; text-align: center; margin-bottom: 40px; }
        .nav-link { display: block; padding: 15px; color: #bbb; text-decoration: none; border-radius: 8px; margin-bottom: 10px; transition: 0.3s; }
        .nav-link:hover, .active { background: rgba(212, 175, 55, 0.1); color: var(--gold); }
        .main { margin-left: 290px; padding: 40px; width: 100%; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .stats-container { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 40px; }
        .stat-card { background: var(--card); padding: 25px; border-radius: 15px; border-left: 4px solid var(--gold); }
        .stat-card h3 { margin: 0; font-size: 0.9rem; color: #888; text-transform: uppercase; letter-spacing: 1px; }
        .stat-card p { margin: 10px 0 0; font-size: 1.8rem; font-weight: bold; color: #fff; }
        .table-box { background: var(--card); border-radius: 15px; padding: 25px; margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { text-align: left; color: var(--gold); padding: 15px; border-bottom: 1px solid #333; font-size: 0.85rem; }
        td { padding: 15px; border-bottom: 1px solid #222; font-size: 0.9rem; vertical-align: top; }
        .status { padding: 5px 12px; border-radius: 20px; font-size: 0.7rem; background: rgba(0, 255, 127, 0.1); color: #00ff7f; text-transform: uppercase; }
        .grade-badge { color: var(--gold); font-weight: bold; font-size: 1.1rem; }
        .feedback-text { display: block; font-size: 0.75rem; color: #888; margin-top: 5px; font-style: italic; }
        input, select { background: #111; border: 1px solid #333; color: #fff; padding: 10px; border-radius: 5px; }
        .btn-gold { background: var(--gold); color: #000; border: none; padding: 10px 25px; font-weight: bold; border-radius: 5px; cursor: pointer; transition: 0.3s; }
        .btn-gold:hover { background: #fff; }
        .action-icons a { text-decoration: none; margin-right: 12px; transition: 0.3s; font-size: 1.1rem; }
        .action-icons .view-icon { color: var(--gold); }
        .action-icons .edit-icon { color: #74c69d; }
        .action-icons .delete-icon { color: #ff4d4d; }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>Elegance</h2>
    <a href="dashboard.php" class="nav-link active"><i class="fas fa-home"></i> Dashboard</a>
    <a href="#" class="nav-link"><i class="fas fa-file-upload"></i> Submissions</a>
    <a href="#" class="nav-link"><i class="fas fa-graduation-cap"></i> Grades</a>
    <a href="logout.php" class="nav-link" style="margin-top: 100px; color: #ff4d4d;"><i class="fas fa-sign-out-alt"></i> Logout</a>
</div>

<div class="main">
    <div class="header">
        <h1>Overview</h1>
        <div style="text-align: right;">
            <span style="display:block; color: var(--gold); font-weight: bold;"><?php echo $user_name; ?></span>
            <small style="color: #666;">ID: 2026-CSE-091</small>
        </div>
    </div>

    <div class="stats-container">
        <div class="stat-card"><h3>Total Submissions</h3><p><?php echo $total_sub; ?></p></div>
        <div class="stat-card"><h3>Pending Feedback</h3><p><?php echo sprintf("%02d", $pending_feedback); ?></p></div>
        <div class="stat-card"><h3>Latest Grade</h3><p><?php echo $latest_grade; ?></p></div>
    </div>

    <!-- SUBMISSION FORM -->
    <div class="table-box">
        <h3 style="color: var(--gold);">New Submission</h3>
        <form action="dashboard.php" method="POST" enctype="multipart/form-data" style="display: flex; gap: 15px; margin-top: 20px; align-items: center;">
            <select name="subject_name" required>
                <option value="Software Dev III">Software Dev III</option>
                <option value="Database Management">Database Management</option>
                <option value="Web Engineering">Web Engineering</option>
            </select>
            <input type="file" name="assignment_file" required>
            <button type="submit" class="btn-gold">Submit Project</button>
        </form>
    </div>

    <!-- RECENT ACTIVITY TABLE -->
    <div class="table-box">
        <h3>Assignment History & Feedback</h3>
        <table>
            <thead>
                <tr>
                    <th width="35%">ASSIGNMENT & FEEDBACK</th>
                    <th>DATE</th>
                    <th>STATUS</th>
                    <th>GRADE</th>
                    <th>ACTION</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT assignments.*, users.id as sid FROM assignments 
                        JOIN users ON assignments.user_id = users.id 
                        WHERE assignments.user_id = '$user_id' ORDER BY assignments.id DESC";
                $res = mysqli_query($conn, $sql);
                
                if(mysqli_num_rows($res) > 0) {
                    while($row = mysqli_fetch_assoc($res)): ?>
                    <tr>
                        <td>
                            <b><?php echo $row['subject_name']; ?></b>
                            <span class="feedback-text">
                                <i class="fas fa-comment-dots"></i> 
                                <?php echo !empty($row['feedback']) ? $row['feedback'] : "No feedback from teacher yet."; ?>
                            </span>
                        </td>
                        <td><?php echo date('M d, Y', strtotime($row['submission_date'])); ?></td>
                        <td><span class="status"><?php echo $row['status']; ?></span></td>
                        <td><span class="grade-badge"><?php echo $row['grade'] ?: '--'; ?></span></td>
                        <td class="action-icons">
                            <a href="uploads/<?php echo $row['file_name']; ?>" target="_blank" class="view-icon" title="View File"><i class="fas fa-eye"></i></a>
                            <a href="edit.php?id=<?php echo $row['id']; ?>" class="edit-icon" title="Edit"><i class="fas fa-edit"></i></a>
                            <a href="dashboard.php?delete_id=<?php echo $row['id']; ?>" class="delete-icon" onclick="return confirm('Delete this submission?')" title="Delete"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php endwhile; 
                } else {
                    echo "<tr><td colspan='5' style='text-align:center; padding: 30px; color: #666;'>No submissions found. Start by uploading your first project!</td></tr>";
                } ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>