<?php
session_start();

$message = ""; // To hold success or error messages
$username = ""; // To retain the username

// Check if there's a message to display and retain the username
if (isset($_SESSION['error'])) {
    $message = "<div class='error-message' id='error-message'>" . $_SESSION['error'] . "</div>";
    if (isset($_SESSION['form_data']['username'])) {
        $username = $_SESSION['form_data']['username']; // Retain username from previous attempt
    }
    unset($_SESSION['error']); // Clear the message after displaying
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login - Artly</title>
    <link rel="stylesheet" href="../styles/index.css">
    <link rel="stylesheet" href="../styles/login.css">
    <link rel="icon" href="../favicon-32x32.png" type="image/x-icon">
    <!-- Include jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // Fade out the error message after 2 seconds
            $('#error-message').delay(2000).fadeOut('slow');

            // Client-side validation before form submission
            $('form').submit(function(event) {
                let username = $('#username').val().trim();
                let password = $('#password').val().trim();

                if (username.length === 0 || password.length === 0) {
                    alert('Username and password are required!');
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
            <ul class="nav-list"></ul>
        </nav>
    </header>
    <main class="main-content">
        <div class="login-container">
            <h1>Login to Artly</h1>
            <?php echo $message; ?>
            <form action="login_handler.php" method="post">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <button type="submit" class="login-button">Login</button>
                </div>
            </form>
            <a href="./signup.php">Sign Up</a>
        </div>
    </main>
    <footer class="main-footer">
        <p>Copyright 2023, Aidan Scudder</p>
    </footer>
</body>

</html>
