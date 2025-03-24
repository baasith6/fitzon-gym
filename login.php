<!-- login.php -->
<?php include('includes/header.php'); ?>
<link rel="stylesheet" href="assets/css/style.css">

<h2>User Login</h2>

<?php if (isset($_GET['success'])): ?>
    <p class="success-msg">Registration successful. Please log in.</p>
<?php endif; ?>

<?php if (isset($_GET['error'])): ?>
    <p class="error-msg"><?php echo htmlspecialchars($_GET['error']); ?></p>
<?php endif; ?>

<form action="queries/handle_login.php" method="POST" id="loginForm">
    <label for="email">Email Address:</label>
    <input type="email" name="email" id="email" required>

    <label for="password">Password:</label>
    <input type="password" name="password" id="password" required>

    <button type="submit">Login</button>
</form>

<script src="assets/js/login_validation.js"></script>

<?php include('includes/footer.php'); ?>
