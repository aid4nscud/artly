<?php
session_start();
require_once '../Dao.php';

$dao = new Dao();

$username = trim($_POST['username']);
$password = trim($_POST['password']);

// Use the authenticate method to check the credentials
$user = $dao->authenticate($username, $password);
// If authentication is successful, user will be an array; otherwise, it will be false
if ($user) {
    // Store user data in session variables
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['role'] = $user['role'];

    // Redirect user to the appropriate dashboard based on their role
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
            // If the role is not recognized, send back to the login page with an error
            $_SESSION['error'] = 'Unauthorized access.';
            header('Location: ./login.php');
            break;
    }
    exit;
} else {
    // If authentication fails, redirect back to the login page with an error
    $_SESSION['error'] = 'Invalid username or password.';
    header('Location: ./login.php');
    exit;
}

?>