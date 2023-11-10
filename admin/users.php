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
$users = $dao->getUsersWithTotalTransactionValue();

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Manage Users - Artly</title>
    <link rel="stylesheet" href="../styles/index.css">
    <link rel="stylesheet" href="../styles/admin-users.css">
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
        <h1 class="main-title">Manage Users</h1>
        <?php echo $message; ?>
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
                            <td>
                                <div class="action-dropdown">
                                    <button class="action-button">Actions</button>
                                    <div class="action-dropdown-content">
                                        <a href="./delete_user_handler.php?id=<?php echo $user['id']; ?>">Delete</a>

                                    </div>
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