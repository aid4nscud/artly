<?php
class Dao
{

    private $host = "localhost";
    private $db = "artly";
    private $user = "root";
    private $pass = "aidanscudder";


    public function getConnection()
    {
        return
            new PDO(
                "mysql:host={$this->host};dbname={$this->db}",
                $this->user,
                $this->pass
            );
    }

    public function authenticate($username, $password)
    {
        $conn = $this->getConnection();
        try {
            // Prepare a select statement
            $stmt = $conn->prepare("SELECT * FROM user WHERE username = :username");
            // Execute the statement with the username parameter
            $stmt->execute(['username' => $username]);
            // Fetch the user from the database
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            // Check if a user was found and the passwords match
            if ($user && $password == $user['password']) {
                return $user;
            }
            // Return false if authentication fails
            return false;
        } catch (PDOException $e) {
            // Handle errors by throwing an exception or returning false
            error_log('Authentication failed: ' . $e->getMessage());
            return false;
        }
    }

    public function signup($username, $email, $password, $role)
    {
        $conn = $this->getConnection();

        try {
            // Prepare the SQL statement to insert a new user
            $stmt = $conn->prepare(
                "INSERT INTO user (username, email, password, role) VALUES (:username, :email, :password, :role)"
            );
            // Bind the parameters to the prepared statement
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':role', $role);
            // Execute the statement
            $stmt->execute();
            // Check if the insert was successful
            if ($stmt->rowCount() > 0) {
                // Retrieve the last inserted ID (user ID)
                $user_id = $conn->lastInsertId();
                // Return the new user as an associative array
                return [
                    "id" => $user_id,
                    "username" => $username,
                    "email" => $email,
                    "role" => $role
                ];
            } else {
                // Insert failed, return false
                return false;
            }
        } catch (PDOException $e) {
            error_log('Signup failed: ' . $e->getMessage());
            return false;
        }
    }

    public function getCollectorArt($user_id)
    {
        $conn = $this->getConnection();
        try {
            $stmt = $conn->prepare("
        SELECT
          art.id,
          art.name,
          art.dimensions,
          art.medium,
          art.image_url
        FROM
          art
        INNER JOIN auction ON art.id = auction.art_id
        WHERE
          auction.winner_id = :user_id AND
          auction.status = 'sold'
      ");

            // Execute the query with the user_id parameter
            $stmt->execute(['user_id' => $user_id]);

            // Fetch all the resulting art pieces into an associative array
            $artPieces = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Return the array of art pieces
            return $artPieces;

        } catch (PDOException $e) {
            // Handle any errors by logging and returning an empty array or false
            error_log('PDOException - ' . $e->getMessage(), 0);
            return [];
        }
    }


    public function getCollectorArtists($user_id)
    {
        $conn = $this->getConnection();
        try {
            // Since the artist table is removed, we only reference the user table now
            $stmt = $conn->prepare("
                SELECT DISTINCT user.*
                FROM user
                JOIN art ON user.id = art.user_id
                JOIN auction ON art.id = auction.art_id
                JOIN transaction ON auction.id = transaction.auction_id
                JOIN bid ON auction.id = bid.auction_id
                WHERE bid.user_id = :user_id AND user.role = 'artist'
            ");
            // Execute the statement with the user_id parameter
            $stmt->execute(['user_id' => $user_id]);
            // Return the result as an array of artist objects
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Handle errors by throwing an exception or returning false
            error_log('getCollectorArtists failed: ' . $e->getMessage());
            return false;
        }
    }

    public function getAllArt()
    {
        $conn = $this->getConnection();
        try {
            // Updated to remove the join with the artist table
            $stmt = $conn->prepare("
            SELECT art.*, user.*
            FROM art
            JOIN user ON art.user_id = user.id
            WHERE user.role = 'artist';
        ");

            $stmt->execute();
            // Return the result as an array of art piece objects
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Handle errors by throwing an exception or returning false
            error_log('getAllArt failed: ' . $e->getMessage());
            return false;
        }
    }


    public function getCollectorBids($user_id)
    {
        $conn = $this->getConnection();
        try {
            $stmt = $conn->prepare("
                SELECT a.*, b.bid_price, b.bid_time, art.name, art.image_url 
                FROM bid b 
                INNER JOIN auction a ON b.auction_id = a.id 
                INNER JOIN art ON a.art_id = art.id 
                WHERE b.user_id = :user_id
                ORDER BY b.bid_time DESC;
            ");

            $stmt->execute(['user_id' => $user_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('getCollectorBids failed: ' . $e->getMessage());
            return false;
        }


    }

    public function getArtistArt($user_id)
    {
        $conn = $this->getConnection();
        try {
            // Updated to use user_id directly
            $stmt = $conn->prepare("
            SELECT * FROM art 
            WHERE user_id = :user_id;
        ");

            $stmt->execute(['user_id' => $user_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('getArtistArt failed: ' . $e->getMessage());
            return false;
        }
    }
    public function getArtistAuctionHistory($user_id)
    {
        $conn = $this->getConnection();
        try {
            // Updated to remove the join with the artist table
            $stmt = $conn->prepare("
            SELECT a.name, auc.end_time, auc.status, a.image_url, auc.start_price
            FROM art a
            JOIN auction auc ON a.id = auc.art_id
            WHERE a.user_id = :user_id
            ORDER BY auc.end_time DESC;
        ");

            $stmt->execute(['user_id' => $user_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('getArtistAuctionHistory failed: ' . $e->getMessage());
            return false;
        }
    }

    public function addNewArt($user_id, $artName, $dimensions, $medium, $imageUrl, $startPrice, $bidIncrement, $auctionDate)
    {
        $conn = $this->getConnection();
        try {
            // Begin transaction
            $conn->beginTransaction();


            $artStmt = $conn->prepare("INSERT INTO art (user_id, name, dimensions, medium, image_url) VALUES (:userId, :name, :dimensions, :medium, :imageUrl)");
            $artStmt->execute([
                'userId' => $user_id,
                'name' => $artName,
                'dimensions' => $dimensions,
                'medium' => $medium,
                'imageUrl' => $imageUrl,

            ]);
            $artId = $conn->lastInsertId();

            // Insert into auction table
            $auctionStmt = $conn->prepare("INSERT INTO auction (art_id, start_price, bid_increment, end_time) VALUES (:artId, :startPrice, :bidIncrement, :auctionDate)");
            $auctionStmt->execute([
                'artId' => $artId,
                'startPrice' => $startPrice,
                'bidIncrement' => $bidIncrement,
                'auctionDate' => $auctionDate
            ]);

            // Commit transaction
            $conn->commit();
            return true;
        } catch (Exception $e) {
            // Rollback transaction on error
            $conn->rollBack();
            error_log("addNewArt failed: " . $e->getMessage());
            return false;
        }
    }

    public function getArtistAuctions($user_id)
    {
        $conn = $this->getConnection();
        try {
            $currentTime = date('Y-m-d H:i:s');

            // Retrieve ongoing auctions
            $ongoingStmt = $conn->prepare("
                SELECT a.*, auc.*, u.username as winner_username
                FROM art a
                JOIN auction auc ON a.id = auc.art_id
                LEFT JOIN user u ON auc.winner_id = u.id
                WHERE a.user_id = :user_id AND auc.end_time > :current_time
                ORDER BY auc.end_time ASC
            ");
            $ongoingStmt->execute(['user_id' => $user_id, 'current_time' => $currentTime]);
            $ongoingAuctions = $ongoingStmt->fetchAll(PDO::FETCH_ASSOC);

            // Retrieve past auctions
            $pastStmt = $conn->prepare("
                SELECT a.*, auc.*, u.username as winner_username
                FROM art a
                JOIN auction auc ON a.id = auc.art_id
                LEFT JOIN user u ON auc.winner_id = u.id
                WHERE a.user_id = :user_id AND auc.end_time <= :current_time
                ORDER BY auc.end_time DESC
            ");
            $pastStmt->execute(['user_id' => $user_id, 'current_time' => $currentTime]);
            $pastAuctions = $pastStmt->fetchAll(PDO::FETCH_ASSOC);

            // Return both lists in an associative array
            return [
                'ongoing' => $ongoingAuctions,
                'past' => $pastAuctions
            ];
        } catch (PDOException $e) {
            error_log('getArtistAuctions failed: ' . $e->getMessage());
            return false;
        }
    }


}

