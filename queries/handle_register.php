<?php
require_once '../includes/db.php';

// Check for POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input
    $name     = filter_var(trim($_POST['name']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email    = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    // Input validation (backend fallback)
    if (strlen($name) < 3 || !preg_match("/^[A-Za-z\s]+$/", $name)) {
        die("Invalid name. Please enter at least 3 characters using only letters and spaces.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email address.");
    }

    if (strlen($password) < 6 || 
        !preg_match('/[A-Z]/', $password) || 
        !preg_match('/[a-z]/', $password) || 
        !preg_match('/[0-9]/', $password) || 
        !preg_match('/[\W_]/', $password)) {
        die("Password must be at least 6 characters long and include uppercase, lowercase, number, and special character.");
    }

    try {
        // Check if email already exists
        $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
        $checkStmt->execute([$email]);
        if ($checkStmt->fetchColumn() > 0) {
            die("Email already registered. Try logging in.");
        }

        // Hash the password securely
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert the new user
        $insertStmt = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'customer')");
        $insertStmt->execute([$name, $email, $hashedPassword]);

        // Redirect to login page with success flag
        header("Location: ../login.php?success=1");
        exit;

    } catch (PDOException $e) {
        // Log the error in real applications
        die("Registration failed. Please try again later.");
    }
} else {
    // Redirect if accessed without POST
    header("Location: ../register.php");
    exit;
}
