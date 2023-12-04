<?php
session_start();
require_once '../Dao.php';

// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../../auth/login.php');
    exit;
}
$message = isset($_SESSION['error']) ? "<div class='error-message'>" . $_SESSION['error'] . "</div>" : '';
unset($_SESSION['error']);
$message = isset($_SESSION['success']) ? "<div class='success'>" . $_SESSION['success'] . "</div>" : '';
unset($_SESSION['success']);

$dao = new Dao();
$auctions = $dao->getAuctions();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Manage Auctions - Artly</title>
    <link rel="stylesheet" href="../styles/index.css">
    <link rel="stylesheet" href="../styles/admin-auctions.css">
    <link rel="icon" href="../favicon-32x32.png" type="image/x-icon">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // Fade out the error and success messages after 3 seconds
            $('.error-message, .success').delay(3000).fadeOut('slow');
        });
    </script>
</head>

<body>

    <header class="main-header">
        <div class="logo">ARTLY</div>
        <nav class="main-nav">
            <ul class="nav-list">
                <li class="nav-item"><a href="./dashboard.php">Manage</a></li>
                <li class="nav-item"><a href="./users.php">Users</a></li>
                <li class="nav-item"><a href="./art.php">Art</a></li>
                <li class="nav-item"><a href="./auctions.php">Auctions</a></li>
                <li class="nav-item"><a href="../../auth/logout_handler.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main class="main-content">
        <h1 class="main-title">Manage Auctions</h1>

        <?php echo $message; ?>
        <section class="auctions-grid">

            <?php foreach ($auctions as $auction):
                $endDateTime = new DateTime($auction['end_time']);
                $now = new DateTime();
                $interval = $now->diff($endDateTime);
                $daysLeft = $interval->days;
                if ($now > $endDateTime) {
                    $daysLeft = 0; // Auction has ended
                }
                ?>
                <div class="auction-card">
                    <img src="<?php echo htmlspecialchars('https://thumbs.dreamstime.com/z/happy-man-okay-sign-portrait-white-background-showing-31418338.jpg'); ?>"
                        alt="Artist" class="artist-profile">
                    <img src="<?php echo htmlspecialchars($auction['image_url']); ?>"
                        alt="<?php echo htmlspecialchars($auction['art_name']); ?>" class="auction-image">
                    <div class="auction-details">
                        <h3>
                            <?php echo htmlspecialchars($auction['art_name']); ?>
                        </h3>
                        <p>
                            <?php echo htmlspecialchars($auction['bid_count']); ?> bids
                        </p>
                        <p>
                            <?php echo $daysLeft; ?> days left
                        </p>
                    </div>
                    <div class="action-dropdown">
                        <button class="action-button">Actions</button>
                        <div class="action-dropdown-content">
                            <a href="./delete_auction_handler.php?id=<?php echo $auction['id']; ?>">Delete</a>

                        </div>
                    </div>
                </div>
            <?php endforeach; ?>


        </section>

    </main>

    <footer class="main-footer">
        <p>Copyright 2023, Aidan Scudder</p>
    </footer>
</body>

</html>