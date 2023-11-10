<?php
session_start();
require_once("../Dao.php");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'artist') {
    header('Location: ../../auth/login.php');
    exit;
}

$dao = new Dao();
$message = isset($_SESSION['error']) ? "<div class='error'>" . $_SESSION['error'] . "</div>" : '';
unset($_SESSION['error']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>New Art - Artly</title>
    <link rel="stylesheet" href="../styles/index.css">
    <link rel="stylesheet" href="../styles/new-art.css">
    <link rel="icon" href="../favicon-32x32.png" type="image/x-icon">
</head>

<body>

    <header class="main-header">
        <div class="logo"><a href="../index.php">ARTLY</a></div>
        <nav class="main-nav">
            <ul class="nav-list">
                <li class="nav-item"><a href="./dashboard.php">Dashboard</a></li>
                <li class="nav-item"><a href="./new-art.php">New Art</a></li>
                <li class="nav-item"><a href="./my-auctions.php">My Auctions</a></li>
                <li class="nav-item"><a href="../../auth/logout_handler.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main class="main-content">
        <h1 class="main-title">Add New Art</h1>

        <section class="new-art-form">
            <?php echo $message; ?>
            <form action="./submit_art_handler.php" method="POST" enctype="multipart/form-data">
                <label for="name">Art Piece Name:</label>
                <input type="text" id="name" name="name" required>

                <label for="image">Upload Image:</label>
                <input type="file" id="image" name="image" accept="image/*" required>

                <label for="dimensions">Dimensions:</label>
                <input type="text" id="dimensions" name="dimensions" placeholder="e.g., 24x36 inches" required>

                <label for="medium">Medium:</label>
                <input type="text" id="medium" name="medium" placeholder="e.g., Oil on canvas" required>

                <label for="description">Description:</label>
                <textarea id="description" name="description" rows="4" required></textarea>

                <label for="price">Set Price $:</label>
                <input type="number" id="price" name="price" min="1" required>

                <label for="auctionDate">Set Auction Date:</label>
                <input type="date" id="auctionDate" name="auctionDate" required>

                <input type="submit" value="Submit">
            </form>
        </section>

    </main>

    <footer class="main-footer">
        <p>Copyright 2023, Aidan Scudder</p>
    </footer>

</body>

</html>