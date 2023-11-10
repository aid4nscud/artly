<?php
session_start();
require_once("../Dao.php");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'artist') {
    header('Location: ../../auth/login.php');
    exit;
}

$dao = new Dao();

$artName = htmlspecialchars(trim($_POST['name']));
$dimensions = htmlspecialchars(trim($_POST['dimensions']));
$medium = htmlspecialchars(trim($_POST['medium']));
$description = htmlspecialchars(trim($_POST['description']));
$startPrice = htmlspecialchars(trim($_POST['price']));
$auctionDate = htmlspecialchars(trim($_POST['auctionDate']));

// Input validation
if (empty($artName) || empty($dimensions) || empty($medium) || empty($description) || empty($startPrice) || empty($auctionDate)) {
    $_SESSION['error'] = 'All fields are required.';
    header('Location: ./new-art.php');
    exit;
}

// Validate the auction date
$dateTimeAuction = DateTime::createFromFormat('Y-m-d', $auctionDate);
if (!$dateTimeAuction || $dateTimeAuction->format('Y-m-d') !== $auctionDate) {
    $_SESSION['error'] = 'Invalid auction date.';
    header('Location: ./new-art.php');
    exit;
}

// Placeholder for image URL - actual URL should be obtained post-upload
$imageUrl = 'https://cdn.media.amplience.net/s/hottopic/11718543_hi?$productMainDesktopRetina$&fmt=auto';

$bidIncrement = 10; // Modify as needed

$success = $dao->addNewArt(
    $_SESSION['user_id'],
    $artName,
    $dimensions,
    $medium,
    $imageUrl,
    $startPrice,
    $bidIncrement,
    $auctionDate
);

if ($success) {
    header('Location: ./dashboard.php');
    exit;
} else {
    $_SESSION['error'] = "Failed to add new art. Please try again.";
    header('Location: ./new-art.php');
    exit;
}

?>