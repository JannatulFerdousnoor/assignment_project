<?php
session_start();
include 'db_connect.php';

// Jodi user age theke login kora thake, tobe take login page-e thakte na diye dashboard-e pathan
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

// Login Logic
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Database check
    $query = "SELECT * FROM users WHERE email = '$email' AND password = '$password' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        
        // Session-e data save kora
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];

        // Redirect use korle back button-er "Resubmit" error r hobe na
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid Email or Access Key!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academic Portal | Premium Access</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Montserrat:wght@300;400;600&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --gold: #D4AF37;
            --dark-card: #151515;
            --bg-color: #1a1a1a;
        }

        * {
            margin: 0; padding: 0; box-sizing: border-box;
            font-family: 'Montserrat', sans-serif;
        }

        body {
            background-color: var(--bg-color);
            background-image: radial-gradient(circle at center, #222 0%, #0a0a0a 100%);
            height: 100vh;
            display: flex; justify-content: center; align-items: center;
        }

        .login-card {
            background: var(--dark-card);
            padding: 60px 45px;
            border-radius: 8px;
            border-left: 4px solid var(--gold);
            width: 450px;
            text-align: left;
            box-shadow: 0 30px 60px rgba(0,0,0,0.7);
        }

        h1 {
            font-family: 'Playfair Display', serif;
            color: var(--gold);
            font-size: 3rem;
            margin-bottom: 5px;
        }

        .subtitle {
            color: #ffffff;
            font-size: 0.75rem;
            letter-spacing: 4px;
            text-transform: uppercase;
            margin-bottom: 45px;
            opacity: 0.6;
        }

        .error-msg {
            color: #ff4d4d;
            font-size: 0.8rem;
            margin-bottom: 20px;
            text-align: center;
            font-weight: 600;
        }

        .input-group { margin-bottom: 25px; }

        input {
            width: 100%; padding: 15px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(212, 175, 55, 0.2);
            border-radius: 4px;
            color: #fff; outline: none;
            transition: 0.4s;
        }

        input:focus {
            border-color: var(--gold);
            background: rgba(212, 175, 55, 0.08);
        }

        .btn {
            width: 100%; padding: 18px;
            background: var(--gold);
            border: none; color: #000;
            font-weight: 700; cursor: pointer;
            text-transform: uppercase;
            letter-spacing: 2px;
            transition: 0.4s;
            border-radius: 4px;
        }

        .btn:hover {
            background: #ffffff;
            transform: translateY(-2px);
        }

        .footer-tag {
            margin-top: 30px;
            font-size: 0.65rem;
            color: #444;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="login-card">
        <h1>Portal Access</h1>
        <div class="subtitle">Assignment Management System</div>
        
        <?php if(isset($error)) { echo '<div class="error-msg">'.$error.'</div>'; } ?>

        <form action="" method="POST">
            <div class="input-group">
                <input type="email" name="email" placeholder="Institutional Email" required>
            </div>
            
            <div class="input-group">
                <input type="password" name="password" placeholder="Access Key" required>
            </div>
            
            <button type="submit" class="btn">Login to Dashboard</button>
        </form>

        <div class="footer-tag">
            NORTHERN UNIVERSITY BANGLADESH | CSE DEPT.
        </div>
    </div>

</body>
</html>