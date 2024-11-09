<?php

require_once "./includes/database.php";


class User{

    public $username;
    public $password;
    public $age;
    public $gender;
    protected $db;

    public function __construct(){
        $this-> db = new Database();
    }
    
    public function addUser() {
        $connection = $this->db->connect(); // Get the database connection
        try {
            // Start a transaction
            $connection->beginTransaction();
    
            // Insert the user into the database
            $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
            $query = $connection->prepare($sql);
            $query->bindParam(':username', $this->username);
    
            // Hashing the password
            $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);
            $query->bindParam(':password', $hashedPassword);
    
            // Execute the user insertion
            if (!$query->execute()) {
                throw new Exception("Failed to add user.");
            }
    
            // Get the last inserted user_id
            $user_id = $connection->lastInsertId();
    
            // Prepare the default gestures
            $defaultGestures = [
                'Com 1' => 'Thumb',
                'Com 2' => 'Thumb Index',
                'Com 3' => 'Thumb Middle',
                'Com 4' => 'Thumb Ring',
                'Com 5' => 'Thumb Pinky',
                'Com 6' => 'Index',
                'Com 7' => 'Index Middle',
                'Com 8' => 'Index Ring',
                'Com 9' => 'Index Pinky',
                'Com 10' => 'Middle',
                'Com 11' => 'Middle Ring',
                'Com 12' => 'Middle Pinky',
                'Com 13' => 'Ring',
                'Com 14' => 'Ring Pinky',
                'Com 15' => 'Pinky',
                'Com 16' => 'Index & Middle & Ring & Pinky',
                'Com 17' => 'Index & Middle & Ring',
                'Com 18' => 'Thumb & Middle & Ring',
                'Com 19' => 'Middle & Ring & Pinky',
                'Com 20' => 'Thumb, Index, Middle, Ring, Pinky'
            ];
    
            // Prepare the SQL query for inserting gestures
            $insertGestureSQL = "INSERT INTO user_gesture (user_id, gesture_name, gesture_value) VALUES (:user_id, :gesture_name, :gesture_value)";
            $gestureQuery = $connection->prepare($insertGestureSQL);
    
            // Bind the user_id once before the loop
            $gestureQuery->bindParam(':user_id', $user_id);
    
            // Insert each default gesture
            foreach ($defaultGestures as $gesture_name => $gesture_value) {
                $gestureQuery->bindParam(':gesture_name', $gesture_name);
                $gestureQuery->bindParam(':gesture_value', $gesture_value);
    
                if (!$gestureQuery->execute()) {
                    throw new Exception("Failed to insert gesture: $gesture_name.");
                }
            }
    
            // Commit the transaction
            $connection->commit();
            return true; // User and gestures added successfully
    
        } catch (Exception $e) {
            // Only attempt to roll back if a transaction was started
            if ($connection->inTransaction()) {
                $connection->rollBack();
            }
            error_log($e->getMessage()); // Log the error for debugging
            return false; // Failed to add user or gestures
        }
    }
    
    
    
    function getUserByUsername($username) {
        $sql = "SELECT * FROM users WHERE username = :username LIMIT 1";
        $stmt = $this->db->connect()->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC); // Fetch user data as an associative array
    }

    public function login($username, $password) {
        // Prepare and execute the query
        $stmt = $this->db->connect()->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verify the password (assuming it's hashed in the database)
        if ($user && password_verify($password, $user['password'])) {
            return $user; // Return the user information
        }

        return false; // Invalid credentials
    }
    
}
?>