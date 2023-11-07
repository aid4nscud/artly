<?php
session_start();
require_once '../Dao.php';

// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'collector') {
    header('Location: ../../auth/login.php');
    exit;
}

$dao = new Dao();
$collectorArt = $dao->getCollectorArt($_SESSION['user_id']);
$artists = $dao->getCollectorArtists($_SESSION['user_id']);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Collector Dashboard</title>
    <link rel="stylesheet" href="../styles/index.css">
    <link rel="stylesheet" href="../styles/collector-dashboard.css">
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
        <h1 class="main-title">Collector Dashboard</h1>

        <h2>Art Pieces</h2>
        <section class="card-list">
            <?php foreach ($collectorArt as $art): ?>
                <div class="card">
                    <img src="<?php echo htmlspecialchars($art['image_url']); ?>"
                        alt="<?php echo htmlspecialchars($art['name']); ?>" class="art-image">
                    <p>
                        <?php echo htmlspecialchars($art['name']); ?>
                    </p>
                </div>
            <?php endforeach; ?>
            <?php if (empty($collectorArt)): ?>
                <p>You don't have any art yet!</p>
            <?php endif; ?>
        </section>



        <h2>My Artists</h2>
        <section class="card-list">
            <?php foreach ($artists as $artist): ?>
                <div class="card">
                    <img src="<?php echo $artist['image_url']; ?>" alt="<?php echo htmlspecialchars($artist['name']); ?>">
                    <p>
                        <?php echo htmlspecialchars($artist['name']); ?>
                    </p>
                </div>
            <?php endforeach; ?>
            <?php if (empty($artists)): ?>
                <p>You haven't bought from any artists yet!</p>
            <?php endif; ?>
        </section>

    </main>

    <footer class="main-footer">
        <p>Copyright 2023, Aidan Scudder</p>
    </footer>

</body>

</html>