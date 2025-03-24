<?php
require_once '../includes/db.php';
session_start();

// Optional: Set strict session parameters
ini_set('session.cookie_httponly', 1);
ini_set('session.use_strict_mode', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    // Backend email format validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../login.php?error=" . urlencode("Invalid email format"));
        exit;
    }

    try {
        // Query user by email
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // OPTIONAL: Regenerate session ID to prevent session fixation
            session_regenerate_id(true);

            // Store user info in session
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['name']    = $user['name'];
            $_SESSION['email']   = $user['email'];
            $_SESSION['role']    = $user['role'];

            // Redirect by role
            switch ($user['role']) {
                case 'admin':
                    header("Location: ../admin_dashboard.php");
                    break;
                case 'staff':
                    header("Location: ../staff_dashboard.php");
                    break;
                default:
                    header("Location: ../customer_dashboard.php");
            }
            exit;
        } else {
            // Log failed login attempt (optional - create a login_logs table if needed)
            // $log = $pdo->prepare("INSERT INTO login_logs (email, ip, timestamp) VALUES (?, ?, NOW())");
            // $log->execute([$email, $_SERVER['REMOTE_ADDR']]);

            header("Location: ../login.php?error=" . urlencode("Invalid email or password"));
            exit;
        }
    } catch (PDOException $e) {
        // Don't expose DB error details to users
        // Log error internally if needed
        header("Location: ../login.php?error=" . urlencode("Unexpected error occurred. Please try again."));
        exit;
    }
} else {
    // Block direct access without POST
    header("Location: ../login.php");
    exit;
}
