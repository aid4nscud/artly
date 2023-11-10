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
    <title>Signup - Artly</title>
    <link rel="stylesheet" href="../styles/index.css">
    <link rel="stylesheet" href="../styles/signup.css">
</head>

<body>
    <header class="main-header">
        <div class="logo"><a href="../index.php">ARTLY</a></div>
        <nav class="main-nav">
            <ul class="nav-list">

            </ul>
        </nav>
    </header>
    <main class="main-content">

        <div class="signup-container">
            <h1>Create Account</h1>

            <?php echo $message; ?>

            <form action="signup_handler.php" method="post">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
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