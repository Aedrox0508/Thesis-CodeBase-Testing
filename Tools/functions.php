<?php

    require_once "database_con.php";


    function validate_field($field) {
        $field = htmlentities($field);
        if (strlen(trim($field)) < 1) {
            return false;
        }
        return true;
    }
    
    function validate_password($password) {
        $password = htmlentities($password);
        if (strlen(trim($password)) < 1) {
            return "Password cannot be empty";
        } elseif (strlen(trim($password)) < 8) {
            return "Password must be at least 8 characters long";
        }
        return true;
    }
    
    function username_exists($username) {
        $conn = get_db_connection();
        if ($conn === null) {
            return false;
        }
    
        $sql = "SELECT user_id FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();
    
        return $stmt->num_rows > 0;
    }
    
    function validate_conPass($cpassword, $password) {
        $cpw = htmlentities($cpassword);
        $pw = htmlentities($password);
        return strcmp($pw, $cpw) === 0;
    }
    
    
    
    
