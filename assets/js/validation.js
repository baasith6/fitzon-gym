// validation.js
document.getElementById("registerForm").addEventListener("submit", function (e) {
    const name = document.getElementById("name").value.trim();
    const email = document.getElementById("email").value.trim();
    const password = document.getElementById("password").value;
    const confirm = document.getElementById("confirm_password").value;

    const nameRegex = /^[A-Za-z\s]{3,}$/; // Only letters & spaces, min 3 characters
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{6,}$/;
    // Min 6 characters, at least 1 uppercase, 1 lowercase, 1 digit, 1 special character

    // Validate Name
    if (!nameRegex.test(name)) {
        alert("Full name must be at least 3 characters and contain only letters and spaces.");
        e.preventDefault();
        return;
    }

    // Validate Email
    if (!emailRegex.test(email)) {
        alert("Please enter a valid email address.");
        e.preventDefault();
        return;
    }

    // Validate Password Strength
    if (!passwordRegex.test(password)) {
        alert("Password must be at least 6 characters and include uppercase, lowercase, number, and special character.");
        e.preventDefault();
        return;
    }

    // Confirm Password Match
    if (password !== confirm) {
        alert("Passwords do not match.");
        e.preventDefault();
        return;
    }
});
