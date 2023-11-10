<?php
session_start();

$message = ""; // To hold success or error messages

// Check if there's a message to display
if (isset($_SESSION['error'])) {
    $message = "<div class='error-message'>" . $_SESSION['error'] . "</div>";
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
                    <input type="text" id="username" name="username" required>
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