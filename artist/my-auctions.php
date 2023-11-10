<?php
session_start();
require_once("../Dao.php");

// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'artist') {
    header('Location: ../../auth/login.php');
    exit;
}

$dao = new Dao();
$auctions = $dao->getArtistAuctions($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>My Auctions - Artly</title>
    <link rel="stylesheet" href="../styles/index.css">
    <link rel="stylesheet" href="../styles/my-auctions.css">
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
        <h1 class="main-title">My Auctions</h1>

        <section class="auction-section">
            <h2>Ongoing Auctions</h2>
            <table class="auction-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Date</th>
                        <th>Start Price</th>
                        <th>No. of Bids</th>
                        <th>Max Bid</th>
                        <th>Image</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($auctions): ?>
                        <?php foreach ($auctions['ongoing'] as $auction): ?>
                            <tr>
                                <td>
                                    <?php echo htmlspecialchars($auction['name']); ?>
                                </td>
                                <td>
                                    <?php echo htmlspecialchars($auction['end_time']); ?>
                                </td>
                                <td>$
                                    <?php echo htmlspecialchars(number_format($auction['start_price'], 2)); ?>
                                </td>
                                <td>
                                    1
                                </td>
                                <td>
                                    1
                                </td>
                                <td><img src="<?php echo htmlspecialchars($auction['image_url']); ?>"
                                        alt="<?php echo htmlspecialchars($auction['name']); ?>" class="table-img"></td>
                            </tr>
                        <?php endforeach; ?>

                    <?php endif; ?>


                </tbody>
            </table>
        </section>


        <section class="auction-section">
            <h2>Past Auctions</h2>
            <table class="auction-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Date</th>
                        <th>Start Price</th>
                        <th>No. of Bids</th>
                        <th>Max Bid</th>
                        <th>Image</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($auctions): ?>
                        <?php foreach ($auctions['past'] as $auction): ?>
                            <tr>
                                <td>
                                    <?php echo htmlspecialchars($auction['name']); ?>
                                </td>
                                <td>
                                    <?php echo htmlspecialchars($auction['end_time']); ?>
                                </td>
                                <td>$
                                    <?php echo htmlspecialchars(number_format($auction['start_price'], 2)); ?>
                                </td>
                                <td>2</td>
                                <td>2</td>
                                <td><img src="<?php echo htmlspecialchars($auction['image_url']); ?>"
                                        alt="<?php echo htmlspecialchars($auction['name']); ?>" class="table-img"></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>

                </tbody>
            </table>
        </section>

    </main>

    <footer class="main-footer">
        <p>Copyright 2023, Aidan Scudder</p>
    </footer>

</body>

</html>