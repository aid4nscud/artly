<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../styles/index.css">
    <link rel="stylesheet" href="../styles/admin-dashboard.css">
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
            </ul>
        </nav>
    </header>

    <main class="main-content">
        <h1 class="main-title">Admin Dashboard</h1>

        <h2>Current Auctions</h2>
        <section class="current-auctions">
        
            <div class="auction-card">
                <img src="../images/sample4.webp" alt="Art1" class="art-image">
                <div class="auction-details">
                    <h3>Art Piece 1</h3>
                    <p>End Date: 01/01/2024</p>
                </div>
            </div>

            <div class="auction-card">
                <img src="../images/sample5.webp" alt="Art1" class="art-image">
                <div class="auction-details">
                    <h3>Art Piece 1</h3>
                    <p>End Date: 01/01/2024</p>
                </div>
            </div>

            <div class="auction-card">
                <img src="../images/sample2.jpeg" alt="Art1" class="art-image">
                <div class="auction-details">
                    <h3>Art Piece 1</h3>
                    <p>End Date: 01/01/2024</p>
                </div>
            </div>

            <div class="auction-card">
                <img src="../images/sample1.webp" alt="Art1" class="art-image">
                <div class="auction-details">
                    <h3>Art Piece 1</h3>
                    <p>End Date: 01/01/2024</p>
                </div>
            </div>

        </section>

        <h2>Statistics</h2>
        <section class="statistics">
           
            <div class="stat">New Users Today: 10</div>
            <div class="stat">Total Users: 100</div>
            <div class="stat">Total Artists: 50</div>
            <div class="stat">Total Collectors: 40</div>
            <div class="stat">Art Pieces Listed: 60</div>
        </section>

        <h2>Recent Transactions</h2>
        <section class="transactions">
           
            <table>
                <thead>
                    <tr>
                        <th>Art Piece Name</th>
                        <th>Date</th>
                        <th>Buyer</th>
                        <th>Seller</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Art1</td>
                        <td>01/01/2024</td>
                        <td>John Doe</td>
                        <td>Jane Smith</td>
                        <td>$500</td>
                    </tr>

                </tbody>
            </table>
        </section>
    </main>

    <footer class="main-footer">
        <p>Copyright 2023, Aidan Scudder</p>
    </footer>
</body>

</html>