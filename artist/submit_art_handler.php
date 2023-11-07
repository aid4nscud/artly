<?php
session_start();
require_once("../Dao.php");

// Ensure the user is logged in as an artist before proceeding
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'artist') {
    // If not, redirect to the login page
    header('Location: ../../auth/login.php');
    exit;
}

$dao = new Dao();


// Collect form data
$artName = trim($_POST['name']);
$dimensions = trim($_POST['dimensions']);
$medium = trim($_POST['medium']);
$description = trim($_POST['description']);
$startPrice = $_POST['price'];
$auctionDate = $_POST['auctionDate'];

// Placeholder for image URL - will be replaced with actual S3 URL post-upload
$imageUrl = 'https://cdn.media.amplience.net/s/hottopic/11718543_hi?$productMainDesktopRetina$&fmt=auto'; // TODO: Update with dynamic S3 URL post-integration

// Simulate the image upload process by using a static URL for now

// Additional details to be collected from the form
// Set a default bid increment or obtain it from the form if you have such an input
$bidIncrement = 10; // You can make this dynamic by adding a form input if needed

// Execute the function to add new art and create auction entry
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

// Check if the operation was successful
if ($success) {
    // On success, redirect to the artist's dashboard
    $_SESSION['message'] = "New art added successfully!";
    header('Location: ./dashboard.php');
    exit;
} else {
    // On failure, handle the error, possibly redirecting back to the form with a message
    $_SESSION['error'] = "Failed to add new art. Please try again.";
    header('Location: ./new-art.php');
    exit;
}

?>