<?php
    require_once "./includes/database.php";

    class Gesture{

        public $gesture_id;
        public $gesture_name;
        public $gesture_value;
        public $custom_value;
        protected $db;

        public function __construct(){
            $this->db = new Database();
        }

        function updateGestureValue($gestureId, $customValue) {
            // Create a new database connection
            $db = new Database();
        
            // Prepare the SQL statement
            $sql = "UPDATE gesture SET gesture_value = :gesture_value WHERE gesture_id = :gesture_id";
            $query = $db->connect()->prepare($sql);
        
            // Bind the parameters
            $query->bindParam(':gesture_value', $customValue);
            $query->bindParam(':gesture_id', $gestureId);
        
            // Execute the update query and return success or failure message
            if ($query->execute()) {
                return "Gesture updated successfully.";
            } else {
                return "Error updating gesture.";
            }
        }
        

        public function get_gestures() {
            $sql = "SELECT * FROM gesture"; // Adjust your query as needed
            $query = $this->db->connect()->prepare($sql);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }

        public function get_thumb_gestures() {
            // Query to retrieve the first 6 gestures related to the thumb
            $sql = "SELECT * FROM gesture ORDER BY gesture_id LIMIT 5"; // Adjust as needed
            $query = $this->db->connect()->prepare($sql);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC); // Fetch all matching records
        }

        public function get_index_gestures() {
            // Query to retrieve the first 6 gestures related to the thumb
            $sql = "SELECT * FROM gesture ORDER BY gesture_id LIMIT 4 OFFSET 5";// Adjust as needed
            $query = $this->db->connect()->prepare($sql);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC); // Fetch all matching records
        }

        public function get_middle_gestures() {
            // Query to retrieve the first 6 gestures related to the thumb
            $sql = "SELECT * FROM gesture ORDER BY gesture_id LIMIT 3 OFFSET 9"; // Adjust as needed
            $query = $this->db->connect()->prepare($sql);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC); // Fetch all matching records
        }

        public function get_ring_gestures() {
            // Query to retrieve the first 6 gestures related to the thumb
            $sql = "SELECT * FROM gesture ORDER BY gesture_id LIMIT 2 OFFSET 12"; // Adjust as needed
            $query = $this->db->connect()->prepare($sql);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC); // Fetch all matching records
        }

        public function get_pinky_gestures() {
            // Query to retrieve the first 6 gestures related to the thumb
            $sql = "SELECT * FROM gesture ORDER BY gesture_id LIMIT 1 OFFSET 14"; // Adjust as needed
            $query = $this->db->connect()->prepare($sql);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC); // Fetch all matching records
        }

    }
?>