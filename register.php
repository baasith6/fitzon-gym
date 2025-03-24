<!-- register.php -->
<?php include('includes/header.php'); ?>
<link rel="stylesheet" href="assets/css/style.css">

<h2>User Registration</h2>

<form id="registerForm" action="queries/handle_register.php" method="POST">
    <label for="name">Full Name:</label>
    <input type="text" name="name" id="name" required>

    <label for="email">Email Address:</label>
    <input type="email" name="email" id="email" required>

    <label for="password">Password:</label>
    <input type="password" name="password" id="password" required>

    <label for="confirm_password">Confirm Password:</label>
    <input type="password" id="confirm_password" required>

    <button type="submit">Register</button>
</form>

<script src="assets/js/validation.js"></script>
<?php include('includes/footer.php'); ?>
