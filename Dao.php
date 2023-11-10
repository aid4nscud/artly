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
        INNER JOIN transaction ON art.auction_id = transaction.auction_id
        WHERE
          transaction.buyer_id = :user_id
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

            // First, insert the art record
            $artStmt = $conn->prepare("INSERT INTO art (user_id, name, dimensions, medium, image_url) VALUES (:user_id, :name, :dimensions, :medium, :imageUrl)");
            $artStmt->execute([
                'user_id' => $user_id,
                'name' => $artName,
                'dimensions' => $dimensions,
                'medium' => $medium,
                'imageUrl' => $imageUrl,
            ]);

            // Get the ID of the newly inserted art record
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
                SELECT a.*, auc.*
                FROM art a
                JOIN auction auc ON a.id = auc.art_id
                WHERE a.user_id = :user_id AND auc.end_time > :current_time
                ORDER BY auc.end_time ASC
            ");
            $ongoingStmt->execute(['user_id' => $user_id, 'current_time' => $currentTime]);
            $ongoingAuctions = $ongoingStmt->fetchAll(PDO::FETCH_ASSOC);
    
            // Retrieve past auctions
            $pastStmt = $conn->prepare("
                SELECT a.*, auc.*
                FROM art a
                JOIN auction auc ON a.id = auc.art_id
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
    

    public function getCurrentAuctions()
    {
        $conn = $this->getConnection();
        try {
            $stmt = $conn->prepare("
                SELECT a.*, art.name, art.image_url 
                FROM auction a 
                JOIN art ON a.art_id = art.id 
                WHERE a.status = 'active'
            ");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('getCurrentAuctions failed: ' . $e->getMessage());
            return false;
        }
    }

    public function getStatistics()
    {
        $conn = $this->getConnection();
        try {
            $users = $conn->query("SELECT COUNT(*) FROM user")->fetchColumn();
            $artists = $conn->query("SELECT COUNT(*) FROM user WHERE role = 'artist'")->fetchColumn();
            $collectors = $conn->query("SELECT COUNT(*) FROM user WHERE role = 'collector'")->fetchColumn();
            $artPieces = $conn->query("SELECT COUNT(*) FROM art")->fetchColumn();

            return [
                'totalUsers' => $users,
                'totalArtists' => $artists,
                'totalCollectors' => $collectors,
                'artPiecesListed' => $artPieces
            ];
        } catch (PDOException $e) {
            error_log('getStatistics failed: ' . $e->getMessage());
            return false;
        }
    }

    public function getRecentTransactions()
    {
        try {
            $conn = $this->getConnection();
            $query = "
                SELECT 
                    art.name AS art_name,
                    auction.end_time AS transaction_date,
                    buyer.username AS buyer_name,
                    seller.username AS seller_name,
                    transaction.final_price
                FROM transaction
                JOIN auction ON transaction.auction_id = auction.id
                JOIN art ON auction.art_id = art.id
                JOIN user AS buyer ON transaction.user_id = buyer.id
                JOIN user AS seller ON art.user_id = seller.id
                ORDER BY auction.end_time DESC
                LIMIT 10;"; // Limit to the 10 most recent transactions

            $stmt = $conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log($e);
            return [];
        }
    }
    public function getUsersWithTotalTransactionValue()
    {
        try {
            $conn = $this->getConnection();
            $query = "SELECT 
                          u.id,
                          u.username,
                          u.date_joined,
                          u.role,
                          COALESCE(SUM(t.amount), 0) AS total_transaction_value
                      FROM 
                          user u
                      LEFT JOIN 
                          transaction t ON u.id = t.buyer_id
                      GROUP BY 
                          u.id";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }


    public function getAuctions()
    {
        try {
            $conn = $this->getConnection();
            $query = "SELECT a.id, ar.name AS art_name, u.username AS artist_name, 
                             a.end_time, IFNULL(COUNT(b.id), 0) AS bid_count, ar.image_url
                      FROM auction a
                      JOIN art ar ON a.art_id = ar.id
                      JOIN user u ON ar.user_id = u.id
                      LEFT JOIN bid b ON a.id = b.auction_id
                      WHERE a.status = 'active'
                      GROUP BY a.id";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log($e);
            return [];
        }
    }


    public function deleteAuction($auction_id)
    {
        try {
            $conn = $this->getConnection();
            $conn->beginTransaction();

            // Delete related records in the bid table
            $stmt = $conn->prepare("DELETE FROM bid WHERE auction_id = :auction_id");
            $stmt->bindParam(':auction_id', $auction_id, PDO::PARAM_INT);
            $stmt->execute();

            // Update the art record linked to this auction
            $stmt = $conn->prepare("UPDATE art SET auction_id = NULL WHERE auction_id = :auction_id");
            $stmt->bindParam(':auction_id', $auction_id, PDO::PARAM_INT);
            $stmt->execute();

            // Delete the auction
            $stmt = $conn->prepare("DELETE FROM auction WHERE id = :auction_id");
            $stmt->bindParam(':auction_id', $auction_id, PDO::PARAM_INT);
            $stmt->execute();

            $conn->commit();
            return true;

        } catch (Exception $e) {
            $conn->rollBack();
            error_log($e->getMessage());
            return false;
        }
    }

    public function deleteUser($user_id)
    {
        try {
            $conn = $this->getConnection();
            $conn->beginTransaction();

            // Delete bids and transactions linked to the user's auctions
            $stmt = $conn->prepare("DELETE b, t FROM bid b 
                                    LEFT JOIN transaction t ON t.auction_id = b.auction_id 
                                    JOIN auction a ON b.auction_id = a.id 
                                    JOIN art ar ON a.art_id = ar.id 
                                    WHERE ar.user_id = :user_id");
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();

            // Delete auctions linked to the user's art
            $stmt = $conn->prepare("DELETE a FROM auction a 
                                    JOIN art ar ON a.art_id = ar.id 
                                    WHERE ar.user_id = :user_id");
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();

            // Delete art created by the user
            $stmt = $conn->prepare("DELETE FROM art WHERE user_id = :user_id");
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();

            // Delete the user
            $stmt = $conn->prepare("DELETE FROM user WHERE id = :user_id");
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();

            $conn->commit();
            return true;
        } catch (Exception $e) {
            $conn->rollBack();
            error_log($e->getMessage());
            return false;
        }
    }

    public function deleteArt($art_id)
    {
        $conn = $this->getConnection();
        try {
            // Start the transaction
            $conn->beginTransaction();

            // Delete auctions linked to the art piece
            $stmt = $conn->prepare("DELETE FROM auction WHERE art_id = :art_id");
            $stmt->bindParam(':art_id', $art_id, PDO::PARAM_INT);
            $stmt->execute();

            // Delete the art piece
            $stmt = $conn->prepare("DELETE FROM art WHERE id = :art_id");
            $stmt->bindParam(':art_id', $art_id, PDO::PARAM_INT);
            $stmt->execute();

            // Commit the transaction
            $conn->commit();
            return true;
        } catch (Exception $e) {
            // Roll back the transaction in case of an error
            $conn->rollBack();
            error_log("Error in deleteArt: " . $e->getMessage());
            return false;
        }
    }




}

