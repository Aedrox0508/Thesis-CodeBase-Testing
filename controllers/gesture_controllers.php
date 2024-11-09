<?php
require_once "./includes/database.php";

class Gesture
{
    public $gesture_id;
    public $gesture_name;
    public $gesture_value;
    public $custom_value;
    protected $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    // Modified updateGestureValue method to use both user_id and gesture_name
    public function updateGestureValue($user_id, $gesture_name, $customValue)
    {
        // Fetch the user_gesture_id based on user_id and gesture_name
        $userGesture = $this->getGestureDataByUserAndName($user_id, $gesture_name);
        
        if ($userGesture) {
            // Update the gesture_value if the user_gesture_id is found
            $stmt = $this->db->connect()->prepare("UPDATE user_gesture SET gesture_value = ? WHERE user_gesture_id = ?");
            $stmt->execute([$customValue, $userGesture['user_gesture_id']]);
        }
    }

    // Method to get the user_gesture_id and gesture_value based on user_id and gesture_name
    public function getGestureDataByUserAndName($user_id, $gesture_name)
    {
        $stmt = $this->db->connect()->prepare("SELECT user_gesture_id, gesture_value FROM user_gesture WHERE user_id = ? AND gesture_name = ?");
        $stmt->execute([$user_id, $gesture_name]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Method to fetch all gestures for a specific user
    public function get_gestures($user_id)
    {
        $sql = "SELECT * FROM user_gesture WHERE user_id = :user_id";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':user_id', $user_id);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Method to fetch thumb gestures for a specific user
    public function get_thumb_gestures($user_id)
    {
        $sql = "SELECT * FROM user_gesture WHERE user_id = :user_id ORDER BY user_gesture_id LIMIT 5";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':user_id', $user_id);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Method to fetch index gestures for a specific user
    public function get_index_gestures($user_id)
    {
        $sql = "SELECT * FROM user_gesture WHERE user_id = :user_id ORDER BY user_gesture_id LIMIT 4 OFFSET 5";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':user_id', $user_id);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Method to fetch middle gestures for a specific user
    public function get_middle_gestures($user_id)
    {
        $sql = "SELECT * FROM user_gesture WHERE user_id = :user_id ORDER BY user_gesture_id LIMIT 3 OFFSET 9";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':user_id', $user_id);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Method to fetch ring gestures for a specific user
    public function get_ring_gestures($user_id)
    {
        $sql = "SELECT * FROM user_gesture WHERE user_id = :user_id ORDER BY user_gesture_id LIMIT 2 OFFSET 12";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':user_id', $user_id);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Method to fetch pinky gestures for a specific user
    public function get_pinky_gestures($user_id)
    {
        $sql = "SELECT * FROM user_gesture WHERE user_id = :user_id ORDER BY user_gesture_id LIMIT 1 OFFSET 14";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':user_id', $user_id);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Method to fetch special gestures for a specific user
    public function get_special_gestures($user_id)
    {
        $sql = "SELECT * FROM user_gesture WHERE user_id = :user_id ORDER BY user_gesture_id LIMIT 5 OFFSET 15";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':user_id', $user_id);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
