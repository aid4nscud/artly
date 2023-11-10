<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Home - Artly</title>
    <link rel="stylesheet" href="styles/index.css">
    <link rel="icon" href="favicon-32x32.png" type="image/x-icon">
</head>

<body>
    <header class="main-header">
        <div class="logo">
            ARTLY
        </div>
        <nav class="main-nav">
            <ul class="nav-list">
                <li class="nav-item">
                    <a
                        href="<?php echo isset($_SESSION['user_id']) ? './auth/logout_handler.php' : './auth/login.php'; ?>">
                        <?php echo isset($_SESSION['user_id']) ? 'Logout' : 'Login'; ?>
                    </a>
                </li>
            </ul>
        </nav>
    </header>

    <main class="main-content">


        <section class="hero">
            <h1>Welcome to Artly</h1>
            <p>Your one-stop platform for buying and selling art.</p>
        </section>


        <section class="description">
            <h2>About Artly</h2>
            <p>Artly is a unique platform designed for artists and art collectors. Here, you can showcase your art,
                participate in auctions, and even build your own collection from other talented artists. Join us and
                become part of this vibrant community.</p>
        </section>

    </main>

    <footer class="main-footer">
        <p>Copyright 2023, Aidan Scudder</p>
    </footer>
</body>

</html>