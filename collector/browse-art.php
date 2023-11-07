<?php
session_start();
require_once '../Dao.php';

// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'collector') {
    header('Location: ../../auth/login.php');
    exit;
}

$dao = new Dao();
$allArt = $dao->getAllArt();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Browse Art</title>
    <link rel="stylesheet" href="../styles/index.css">
    <link rel="stylesheet" href="../styles/browse-art.css">
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
        <h1 class="main-title">Browse Art</h1>

        <section class="art-grid">
            <?php if ($allArt): ?>
                <?php foreach ($allArt as $art): ?>
                    <div class="card">
                        <img src="<?php echo htmlspecialchars($art['image_url']); ?>"
                            alt="<?php echo htmlspecialchars($art['name']); ?>" class="art-image">
                        <div class="art-details">
                            <h3>
                                <?php echo htmlspecialchars($art['name']); ?>
                            </h3>
                            <p>
                                <?php echo htmlspecialchars($art['medium']); ?>
                            </p>

                            <button class="buy-button">Buy/Bid</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No art pieces found.</p>
            <?php endif; ?>

        </section>

    </main>

    <footer class="main-footer">
        <p>Copyright 2023, Aidan Scudder</p>
    </footer>

</body>

</html>