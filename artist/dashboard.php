<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Artist Dashboard</title>
    <link rel="stylesheet" href="../styles/index.css">
    <link rel="stylesheet" href="../styles/artist-dashboard.css">
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
        <h1 class="main-title">Artist Dashboard</h1>
        <section class="portfolio-section">
            <h2>My Portfolio</h2>
            <ul class="portfolio-list">
                <li><img src="../images/sample1.webp" alt="Sample Art 1"></li>
                <li><img src="../images/sample2.jpeg" alt="Sample Art 2"></li>
                <li><img src="../images/sample3.jpeg" alt="Sample Art 3"></li>

            </ul>
        </section>


        <section class="auction-history">
            <h2>Auction History</h2>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Image</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Artwork 1</td>
                        <td>2023-01-01</td>
                        <td>Sold</td>
                        <td><img src="../images/sample1.webp" alt="Sample Art 1" class="table-img"></td>
                        <td>$500</td>
                    </tr>

                </tbody>
            </table>
        </section>


        <section class="earnings-graph">
            <h2>Earnings</h2>
            <div id="lineGraph">Line Graph Placeholder</div>
        </section>

    </main>

    <footer class="main-footer">
        <p>Copyright 2023, Aidan Scudder</p>
    </footer>

</body>

</html>