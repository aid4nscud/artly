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
$allArt = $dao->getAllArt();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Manage Art - Artly</title>
    <link rel="stylesheet" href="../styles/index.css">
    <link rel="stylesheet" href="../styles/admin-art.css">
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
        <h1 class="main-title">Manage Art</h1>
        <?php echo $message; ?>
        <section class="art-grid">
            <?php if ($allArt): ?>
                <?php foreach ($allArt as $art): ?>
                    <div class="art-card">
                        <img src="<?php echo htmlspecialchars($art['image_url']); ?>"
                            alt="<?php echo htmlspecialchars($art['name']); ?>" class="art-image">
                        <div class="art-details">
                            <h3>
                                <?php echo htmlspecialchars($art['name']); ?>
                            </h3>
                            <p>
                                <?php echo htmlspecialchars($art['medium']); ?>
                            </p>
                        </div>
                        <div class="action-dropdown">
                            <button class="action-button">Actions</button>
                            <div class="action-dropdown-content">
                                <a href="./delete_art_handler.php?id=<?php echo $art['id']; ?>">Delete</a>

                            </div>
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