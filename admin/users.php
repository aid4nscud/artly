<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Users</title>
    <link rel="stylesheet" href="../styles/index.css">
    <link rel="stylesheet" href="../styles/admin-users.css">
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
        <h1 class="main-title">Users</h1>
        <section class="users">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Date Joined</th>
                        <th>Role</th>
                        <th>Total Transaction Value</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>John Doe</td>
                        <td>01/01/2021</td>
                        <td>Artist</td>
                        <td>$1000</td>
                        <td>
                            <button class="action-button">Actions</button>
                            <div class="action-dropdown">
                                <a href="#">View</a>
                                <a href="#">Edit</a>
                                <a href="#">Delete</a>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Jane Smith</td>
                        <td>02/15/2021</td>
                        <td>Collector</td>
                        <td>$500</td>
                        <td>
                            <button class="action-button">Actions</button>
                            <div class="action-dropdown">
                                <a href="#">View</a>
                                <a href="#">Edit</a>
                                <a href="#">Delete</a>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Emily Brown</td>
                        <td>03/20/2022</td>
                        <td>Admin</td>
                        <td>$2000</td>
                        <td>
                            <button class="action-button">Actions</button>
                            <div class="action-dropdown">
                                <a href="#">View</a>
                                <a href="#">Edit</a>
                                <a href="#">Delete</a>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Robert Lee</td>
                        <td>11/05/2020</td>
                        <td>Artist</td>
                        <td>$800</td>
                        <td>
                            <button class="action-button">Actions</button>
                            <div class="action-dropdown">
                                <a href="#">View</a>
                                <a href="#">Edit</a>
                                <a href="#">Delete</a>
                            </div>
                        </td>
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