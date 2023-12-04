<?php
session_start();
require_once '../Dao.php';

$username = trim($_POST['username']);
$email = trim($_POST['email']);
$password = $_POST['password']; //password should be hashed
$role = $_POST['role'];

$emailRegex = '/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/';

if (!preg_match($emailRegex, $email)) {
    $_SESSION['error'] = 'Invalid email format.';
    header('Location: ./signup.php');
    exit;
}

$dao = new Dao();

try {
    $user = $dao->signup($username, $email, $password, $role);
    if ($user) {
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
            default:
                // If the role is not recognized, send back to the login page with an error
                $_SESSION['error'] = 'Unauthorized access.';
                header('Location: ./login.php');
                break;
        }
    } else {
        $_SESSION['error'] = "Failed to create account.";
        header('Location: ./signup.php');
    }
} catch (Exception $e) {
    $_SESSION['error'] = "Error: " . $e->getMessage();
    header('Location: ./signup.php');
}
?>