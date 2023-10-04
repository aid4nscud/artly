<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Auctions</title>
    <link rel="stylesheet" href="../styles/index.css">
    <link rel="stylesheet" href="../styles/my-auctions.css">
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
        <h1 class="main-title">My Auctions</h1>

        <section class="auction-section">
            <h2>Ongoing Auctions</h2>
            <table class="auction-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Date</th>
                        <th>Start Price</th>
                        <th>No. of Bids</th>
                        <th>Max Bid</th>
                        <th>Image</th>
                    </tr>
                </thead>
                <tbody>
               
                    <tr>
                        <td>Artwork 1</td>
                        <td>2023-10-02</td>
                        <td>$100</td>
                        <td>5</td>
                        <td>$200</td>
                        <td><img src="../images/sample4.webp" alt="Sample Art 1" class="table-img"></td>
                    </tr>
                   
                </tbody>
            </table>
        </section>

       
        <section class="auction-section">
            <h2>Past Auctions</h2>
            <table class="auction-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Date</th>
                        <th>Start Price</th>
                        <th>No. of Bids</th>
                        <th>Max Bid</th>
                        <th>Image</th>
                    </tr>
                </thead>
                <tbody>
                  
                    <tr>
                        <td>Artwork 2</td>
                        <td>2023-09-01</td>
                        <td>$150</td>
                        <td>8</td>
                        <td>$300</td>
                        <td><img src="../images/sample5.webp" alt="Sample Art 2" class="table-img"></td>
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
