<?php
session_start();
require_once("../Dao.php");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'artist') {
    header('Location: ../../auth/login.php');
    exit;
}

$dao = new Dao();
$message = isset($_SESSION['error']) ? "<div class='error'>" . $_SESSION['error'] . "</div>" : '';
$formData = isset($_SESSION['form_data']) ? $_SESSION['form_data'] : [];
unset($_SESSION['error'], $_SESSION['form_data']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>New Art - Artly</title>
    <link rel="stylesheet" href="../styles/index.css">
    <link rel="stylesheet" href="../styles/new-art.css">
    <link rel="icon" href="../favicon-32x32.png" type="image/x-icon">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <style>
        .error-message {
            color: red;
            margin-bottom: 10px;
        }
    </style>
    <script>
        $(document).ready(function () {
            $('form').submit(function (event) {
                let isValid = true;
                let errorMessage = '';

                // Validate Art Piece Name
                if ($('#name').val().trim() === '') {
                    errorMessage += '<p>Art Piece Name is required.</p>';
                    isValid = false;
                }

                // Validate Image Upload
                if ($('#image').val() === '') {
                    errorMessage += '<p>Please upload an image.</p>';
                    isValid = false;
                }

                // Validate Dimensions
                if ($('#dimensions').val().trim() === '') {
                    errorMessage += '<p>Dimensions are required.</p>';
                    isValid = false;
                }

                // Validate Medium
                if ($('#medium').val().trim() === '') {
                    errorMessage += '<p>Medium is required.</p>';
                    isValid = false;
                }

                // Validate Description
                if ($('#description').val().trim() === '') {
                    errorMessage += '<p>Description is required.</p>';
                    isValid = false;
                }

                // Validate Price
                if ($('#price').val().trim() === '' || isNaN($('#price').val()) || parseFloat($('#price').val()) <= 0) {
                    errorMessage += '<p>Set a valid price.</p>';
                    isValid = false;
                }

                // Validate Auction Date
                if ($('#auctionDate').val().trim() === '') {
                    errorMessage += '<p>Auction Date is required.</p>';
                    isValid = false;
                }

                // Show error messages
                if (!isValid) {
                    $('.error-messages').html(errorMessage).fadeIn().delay(5000).fadeOut('slow');
                    event.preventDefault(); // Prevent form submission
                }
            });
        });
    </script>
</head>

</head>

<body>

    <header class="main-header">
        <div class="logo"><a href="../index.php">ARTLY</a></div>
        <nav class="main-nav">
            <ul class="nav-list">
                <li class="nav-item"><a href="./dashboard.php">Dashboard</a></li>
                <li class="nav-item"><a href="./new-art.php">New Art</a></li>
                <li class="nav-item"><a href="./my-auctions.php">My Auctions</a></li>
                <li class="nav-item"><a href="../../auth/logout_handler.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main class="main-content">
        <h1 class="main-title">Add New Art</h1>

        <section class="new-art-form">
            <?php echo $message; ?>
            <form action="./submit_art_handler.php" method="POST" enctype="multipart/form-data">
                <label for="name">Art Piece Name:</label>
                <input type="text" id="name" name="name"
                    value="<?php echo htmlspecialchars($formData['name'] ?? ''); ?>" required>
                <label for="image">Upload Image:</label>
                <input type="file" id="image" name="image" accept="image/*" required>

                <label for="dimensions">Dimensions:</label>
                <input type="text" id="dimensions" name="dimensions"
                    value="<?php echo htmlspecialchars($formData['dimensions'] ?? ''); ?>"
                    placeholder="e.g., 24x36 inches" required>

                <label for="medium">Medium:</label>
                <input type="text" id="medium" name="medium"
                    value="<?php echo htmlspecialchars($formData['medium'] ?? ''); ?>" placeholder="e.g., Oil on canvas"
                    required>

                <label for="description">Description:</label>
                <textarea id="description" name="description" rows="4"
                    required><?php echo htmlspecialchars($formData['description'] ?? ''); ?></textarea>

                <label for="price">Set Price $:</label>
                <input type="number" id="price" name="price"
                    value="<?php echo htmlspecialchars($formData['price'] ?? ''); ?>" min="1" required>

                <label for="auctionDate">Set Auction Date:</label>
                <input type="date" id="auctionDate" name="auctionDate"
                    value="<?php echo htmlspecialchars($formData['auctionDate'] ?? ''); ?>" required>

                <input type="submit" value="Submit">
            </form>
        </section>

    </main>

    <footer class="main-footer">
        <p>Copyright 2023, Aidan Scudder</p>
    </footer>

</body>

</html>