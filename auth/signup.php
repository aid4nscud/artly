<?php
session_start();

$message = ""; // To hold success or error messages
$username = ""; // To retain the username
$email = ""; // To retain the email

// Check if there's a message to display and retain the username and email
if (isset($_SESSION['error'])) {
    $message = "<div class='error-message' id='error-message'>" . $_SESSION['error'] . "</div>";
    if (isset($_SESSION['form_data']['username'])) {
        $username = $_SESSION['form_data']['username']; // Retain username from previous attempt
    }
    if (isset($_SESSION['form_data']['email'])) {
        $email = $_SESSION['form_data']['email']; // Retain email from previous attempt
    }
    unset($_SESSION['error']); // Clear the message after displaying
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Signup - Artly</title>
    <link rel="stylesheet" href="../styles/index.css">
    <link rel="stylesheet" href="../styles/signup.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <link rel="icon" href="../favicon-32x32.png" type="image/x-icon">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            // Fade out the error message after 2 seconds
            $('#error-message').delay(2000).fadeOut('slow');

            // Client-side validation before form submission
            $('#signupForm').submit(function (event) {
                let username = $('#username').val().trim();
                let email = $('#email').val().trim();
                let password = $('#password').val().trim();

                if (username.length === 0 || email.length === 0 || password.length === 0) {
                    alert('All fields are required!');
                    event.preventDefault(); // Prevent form submission
                }
            });
        });
    </script>
</head>

<body>
    <header class="main-header">
        <div class="logo"><a href="../index.php">ARTLY</a></div>
        <nav class="main-nav">
            <ul class="nav-list">
                <!-- Navigation items -->
            </ul>
        </nav>
    </header>
    <main class="main-content">

        <div class="signup-container">
            <h1>Create Account</h1>

            <?php echo $message; ?>

            <form id="signupForm" action="signup_handler.php" method="post">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="role">Role:</label>
                    <select id="role" name="role" required>
                        <option value="artist">Artist</option>
                        <option value="collector">Collector</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="signup-button">Signup</button>
                </div>
            </form>
            <a href="./login.php">Login</a>
        </div>
    </main>
    <footer class="main-footer">
        <p>Copyright 2023, Aidan Scudder</p>
    </footer>
</body>

</html>
