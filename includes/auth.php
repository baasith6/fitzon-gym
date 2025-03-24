<?php
session_start();

// Check if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?error=" . urlencode("Please log in to access this page."));
    exit;
}
