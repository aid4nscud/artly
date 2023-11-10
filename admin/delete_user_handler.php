<?php
session_start();
require_once("../Dao.php");

// Ensure the user is logged in as an admin before proceeding
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    // If not, redirect to the login page
    header('Location: ../../auth/login.php');
    exit;
}

$dao = new Dao();

$userId = isset($_GET['id']) ? $_GET['id'] : null;

if ($userId) {
    // Delete the auction
    $success = $dao->deleteUser($userId);
    if (!$success) {
        $_SESSION['error'] = 'Unable to delete this user at the moment';
        header('Location: ./users.php');
    } else {
        // Redirect to the admin auctions page with a success message
        $_SESSION['message'] = 'User deleted successfully.';
        header('Location: ./users.php');
    }


} else {
    // Redirect to the admin auctions page with an error message
    $_SESSION['error'] = 'Invalid user ID.';
    header('Location: ./users.php');
}

?>