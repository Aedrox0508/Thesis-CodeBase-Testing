
<?php
    $hostname = "localhost";
    $username = "u107798476_movewave_admin";
    $password = "Movewave_admin123";  
    $database = "u107798476_movewave_db";

    // Create the connection to the database
    $conn = mysqli_connect($hostname, $username, $password, $database);

    // Check if the connection was successful
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Check if gesture_name is posted
   if (isset($_POST['gesture_name'])) {
       $gesture_name = $_POST['gesture_name'];

        // Prepare the SQL query to fetch the flex_gesture based on gesture_name
        $sql = "SELECT flex_gesture FROM test_data WHERE gesture_name = '$gesture_name'";
        $result = $conn->query($sql);
        
        // Check if a result is found
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo $row['flex_gesture'];  // Send the flex_gesture as the response
        } else {
            echo "No matching gesture found";
        }
    }


    // Close the database connection
    mysqli_close($conn);
?>
