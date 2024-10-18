
<?php
    require_once "./includes/database.php";

    class User{
        public $user_id;
        public $username;
        public $password;

        protected $db;
        public function __construct(){
            $this->db = new Database();
        }

        function addUser(){
            $sql = "INSERT INTO users (username, password)
            VALUES (:username, :password);";

            $query = $this->db->connect()->prepare($sql);
            $query->bindParam(':username', $this->username);
            $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);
            $query->bindParam(':password', $hashedPassword);

            if ($query->execute()) {
                return true;
            } else {
                return false;
            }
        }

        function getUserByUsername($username) {
            // Assuming $db is your database connection
            global $db;
    
            $stmt = $db->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC); // Fetch user data as an associative array
        }
    }

?>