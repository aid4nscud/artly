<?php
session_start();
require_once '../Dao.php';

// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../../auth/login.php');
    exit;
}

$dao = new Dao();

$currentAuctions = $dao->getCurrentAuctions();
$statistics = $dao->getStatistics();
$recentTransactions = $dao->getRecentTransactions();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Artly</title>
    <link rel="stylesheet" href="../styles/index.css">
    <link rel="stylesheet" href="../styles/admin-dashboard.css">
    <link rel="icon" href="../favicon-32x32.png" type="image/x-icon">
</head>

<body>

    <header class="main-header">
        <div class="logo"><a href="../index.php">ARTLY</a></div>
        <nav class="main-nav">
            <ul class="nav-list">
                <li class="nav-item"><a href="./dashboard.php">Dashboard</a></li>
                <li class="nav-item"><a href="./users.php">Users</a></li>
                <li class="nav-item"><a href="./art.php">Art</a></li>
                <li class="nav-item"><a href="./auctions.php">Auctions</a></li>
                <li class="nav-item"><a href="../../auth/logout_handler.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main class="main-content">
        <h1 class="main-title">Admin Dashboard</h1>

        <h2>Current Auctions</h2>
        <section class="current-auctions">
            <?php foreach ($currentAuctions as $auction): ?>
                <div class="auction-card">
                    <img src="<?php echo htmlspecialchars($auction['image_url']); ?>"
                        alt="<?php echo htmlspecialchars($auction['name']); ?>" class="art-image">
                    <div class="auction-details">
                        <h3>
                            <?php echo htmlspecialchars($auction['name']); ?>
                        </h3>
                        <p>End Date:
                            <?php echo htmlspecialchars($auction['end_time']); ?>
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>
        </section>

        <h2>Statistics</h2>
        <section class="statistics">

            <div class="stat">Total Users:
                <?php echo $statistics['totalUsers']; ?>
            </div>
            <div class="stat">Total Artists:
                <?php echo $statistics['totalArtists']; ?>
            </div>
            <div class="stat">Total Collectors:
                <?php echo $statistics['totalCollectors']; ?>
            </div>
            <div class="stat">Art Pieces Listed:
                <?php echo $statistics['artPiecesListed']; ?>
            </div>
        </section>

        <h2>Recent Transactions</h2>
        <section class="transactions">
            <?php if (empty($collectorArt)): ?>
                <p>No transactions found</p>
            <?php endif; ?>
            <?php if (!empty($collectorArt)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Art Piece Name</th>
                            <th>Date</th>
                            <th>Buyer</th>
                            <th>Seller</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentTransactions as $transaction): ?>
                            <tr>
                                <td>
                                    <?php echo htmlspecialchars($transaction['art_name']); ?>
                                </td>
                                <td>
                                    <?php echo htmlspecialchars($transaction['date']); ?>
                                </td>
                                <td>
                                    <?php echo htmlspecialchars($transaction['buyer']); ?>
                                </td>
                                <td>
                                    <?php echo htmlspecialchars($transaction['seller']); ?>
                                </td>
                                <td>$
                                    <?php echo htmlspecialchars($transaction['price']); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>
                </table>
            <?php endif; ?>

        </section>
    </main>

    <footer class="main-footer">
        <p>Copyright 2023, Aidan Scudder</p>
    </footer>
</body>

</html>