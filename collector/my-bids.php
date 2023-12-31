<?php
session_start();
require_once '../Dao.php';

// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'collector') {
    header('Location: ../../auth/login.php');
    exit;
}

$dao = new Dao();
$bids = $dao->getCollectorBids($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>My Bids - Artly</title>
    <link rel="stylesheet" href="../styles/index.css">
    <link rel="stylesheet" href="../styles/my-bids.css">
    <link rel="icon" href="../favicon-32x32.png" type="image/x-icon">
</head>

<body>

    <header class="main-header">
        <div class="logo"><a href="../index.php">ARTLY</a></div>
        <nav class="main-nav">
            <ul class="nav-list">
                <li class="nav-item"><a href="./dashboard.php">Dashboard</a></li>
                <li class="nav-item"><a href="./browse-art.php">Browse Art</a></li>
                <li class="nav-item"><a href="./my-bids.php">My Bids</a></li>
                <li class="nav-item"><a href="../../auth/logout_handler.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main class="main-content">
        <h1 class="main-title">My Bids</h1>


        <section class="art-grid">
            <?php if ($bids): ?>
                <?php foreach ($bids as $bid): ?>
                    <div class="art-card">
                        <div class="final-price">
                            <?php echo "$" . htmlspecialchars($bid['bid_price']); ?>
                        </div>
                        <img src="../images/<?php echo htmlspecialchars($bid['image_url']); ?>"
                            alt="<?php echo htmlspecialchars($bid['name']); ?>" class="art-image">
                        <div class="art-details">
                            <h3>
                                <?php echo htmlspecialchars($bid['name']); ?>
                            </h3>
                            <p>Placed on
                                <?php echo htmlspecialchars($bid['bid_time']); ?>
                            </p>
                            <div class="status-label">
                                <?php echo ($bid['status'] === 'sold') ? 'Bought' : 'Bid'; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No bids found.</p>
            <?php endif; ?>

        </section>

    </main>

    <footer class="main-footer">
        <p>Copyright 2023, Aidan Scudder</p>
    </footer>

</body>

</html>