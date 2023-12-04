<?php
session_start();
require_once '../Dao.php';

$dao = new Dao();

// Input sanitization
$username = htmlspecialchars(trim($_POST['username']));
$password = htmlspecialchars(trim($_POST['password']));

// Input validation
if (empty($username) || empty($password)) {
    $_SESSION['error'] = 'Username and password are required.';
    header('Location: ./login.php');
    exit;
}

// Check the credentials
$user = $dao->authenticate($username, $password);

// If authentication is successful, user will be an array; otherwise, it will be false
if ($user) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['role'] = $user['role'];

    switch ($_SESSION['role']) {
        case 'artist':
            header('Location: ../artist/dashboard.php');
            break;
        case 'collector':
            header('Location: ../collector/dashboard.php');
            break;
        case 'admin':
            header('Location: ../admin/dashboard.php');
            break;
        default:
            $_SESSION['error'] = 'Unauthorized access.';
            header('Location: ./login.php');
            break;
    }
    exit;
} else {
    $_SESSION['error'] = 'Invalid username or password.';
    header('Location: ./login.php');
    exit;
}

?>
