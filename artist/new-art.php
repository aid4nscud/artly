<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>New Art</title>
    <link rel="stylesheet" href="../styles/index.css">
    <link rel="stylesheet" href="../styles/new-art.css">
</head>

<body>

    <header class="main-header">
        <div class="logo"><a href="../index.php">ARTLY</a></div>
        <nav class="main-nav">
            <ul class="nav-list">
                <li class="nav-item"><a href="./dashboard.php">Dashboard</a></li>
                <li class="nav-item"><a href="./new-art.php">New Art</a></li>
                <li class="nav-item"><a href="./my-auctions.php">My Auctions</a></li>
            </ul>
        </nav>
    </header>

    <main class="main-content">
        <h1 class="main-title">Add New Art</h1>
        <section class="new-art-form">
            <form action="/submit-art" method="POST" enctype="multipart/form-data">
                <label for="name">Art Piece Name:</label>
                <input type="text" id="name" name="name" required>

                <label for="image">Upload Image:</label>
                <input type="file" id="image" name="image" accept="image/*" required>

                <label for="description">Description:</label>
                <textarea id="description" name="description" rows="4" required></textarea>

                <label for="price">Set Price $:</label>
                <input type="number" id="price" name="price" min="1" required>

                <label for="auctionDate">Set Auction Date:</label>
                <input type="date" id="auctionDate" name="auctionDate" required>

                <input type="submit" value="Submit">
            </form>
        </section>

    </main>

    <footer class="main-footer">
        <p>Copyright 2023, Aidan Scudder</p>
    </footer>

</body>

</html>