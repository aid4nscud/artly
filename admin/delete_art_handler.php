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

$artId = isset($_GET['id']) ? $_GET['id'] : null;

if ($artId) {
    // Delete the art piece
    $success = $dao->deleteArt($artId);
    if (!$success) {
        $_SESSION['error'] = 'Unable to delete this art piece at the moment';
        header('Location: ./auctions.php');
    } else {
        // Redirect to the admin auctions page with a success message
        $_SESSION['success'] = 'Art piece deleted successfully.';
        header('Location: ./auctions.php');
    }


} else {
    // Redirect to the admin auctions page with an error message
    $_SESSION['error'] = 'Invalid auction ID.';
    header('Location: ./auctions.php');
}

?>