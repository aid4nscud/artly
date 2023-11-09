<?php
session_start();
require_once '../Dao.php';

// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../../auth/login.php');
    exit;
}

$dao = new Dao();
$users = $dao->getUsersWithTotalTransactionValue();

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Users</title>
    <link rel="stylesheet" href="../styles/index.css">
    <link rel="stylesheet" href="../styles/admin-users.css">
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
        <h1 class="main-title">Users</h1>
        <section class="users">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Date Joined</th>
                        <th>Role</th>
                        <th>Total Transaction Value</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td>
                                <?php echo htmlspecialchars($user['username']); ?>
                            </td>
                            <td>
                                <?php echo htmlspecialchars($user['date_joined']); ?>
                            </td>
                            <td>
                                <?php echo htmlspecialchars($user['role']); ?>
                            </td>
                            <td>$
                                <?php echo htmlspecialchars(number_format($user['total_transaction_value'], 2)); ?>
                            </td>
                            <td><button class="action-button">Actions</button>
                                <div class="action-dropdown">
                                    <a href="#">View</a>
                                    <a href="#">Edit</a>
                                    <a href="#">Delete</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </main>

    <footer class="main-footer">
        <p>Copyright 2023, Aidan Scudder</p>
    </footer>
</body>

</html>