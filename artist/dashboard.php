<?php
session_start();
require_once("../Dao.php");

// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'artist') {
    header('Location: ../../auth/login.php');
    exit;
}

$dao = new Dao();
$portfolioPieces = $dao->getArtistArt($_SESSION['user_id']);
$auctionHistory = $dao->getArtistAuctionHistory($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Artist Dashboard - Artly</title>
    <link rel="stylesheet" href="../styles/index.css">
    <link rel="stylesheet" href="../styles/artist-dashboard.css">
    <link rel="icon" href="../favicon-32x32.png" type="image/x-icon">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        <h1 class="main-title">Artist Dashboard</h1>
        <section class="portfolio-section">
            <h2>My Portfolio</h2>
            <ul class="portfolio-list">
                <?php if ($portfolioPieces): ?>
                    <?php foreach ($portfolioPieces as $piece): ?>
                        <li>
                            <img class="table-img" src="<?php echo htmlspecialchars($piece['image_url']); ?>"
                                alt="<?php echo htmlspecialchars($piece['name']); ?>">

                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li>No art pieces found.</li>
                <?php endif; ?>

            </ul>
        </section>


        <section class="auction-history">
            <h2>Auction History</h2>
            <?php if ($auctionHistory): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Image</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($auctionHistory as $auction): ?>
                            <tr>
                                <td>
                                    <?php echo htmlspecialchars($auction['name']); ?>
                                </td>
                                <td>
                                    <?php echo htmlspecialchars($auction['end_time']); ?>
                                </td>
                                <td>
                                    <?php echo htmlspecialchars($auction['status']); ?>
                                </td>
                                <td><img class="table-img" src="<?php echo htmlspecialchars($piece['image_url']); ?>"
                                        alt="<?php echo htmlspecialchars($piece['name']); ?>">
                                </td>
                                <td>$
                                    <?php echo htmlspecialchars(number_format($auction['start_price'], 2)); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No auction history found.</p>
            <?php endif; ?>
        </section>


        <section class="earnings-graph">
            <h2>Earnings</h2>
            <canvas id="earningsLineGraph"></canvas>
        </section>
        <script>
            $(document).ready(function () {
                var ctx = $('#earningsLineGraph');
                var earningsLineGraph = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                        datasets: [{
                            label: 'Earnings',
                            data: [0, 100, 200, 300, 200, 300, 400], // Example data
                            backgroundColor: 'rgba(0, 123, 255, 0.5)',
                            borderColor: 'rgba(0, 123, 255, 1)',
                            borderWidth: 2
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            });
        </script>

    </main>

    <footer class="main-footer">
        <p>Copyright 2023, Aidan Scudder</p>
    </footer>

</body>

</html>