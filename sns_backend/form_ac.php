<?php

include('db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get JSON input data
    $inputData = file_get_contents('php://input');
    $data = json_decode($inputData, true);
    
    // Extract data from the input
    $mobile_no = $data['phone'];
    $location = $data['location'];
    $type = $data['type'];
    $sub_service = $data['repairInspection'];
    $brand = $data['brand'];
    $date = $data['date'];
    $service = $data['service'];
    $time = $data['time'];

    // For debugging purposes (not recommended in production):
    echo $mobile_no;
    echo $location;
    echo $type;
    echo $brand;
    echo $date;
    echo $service;
    echo $sub_service;
    echo $time;

    // SQL query with prepared statement
    $sql = 'INSERT INTO `ac_tbl` (`location`, `actype`, `typ_service`, `sub_service`, `phoneno`, `appointment_date`, `appointment_time`, `brand`) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)';

    // Prepare the SQL statement
    $stmt = $conn->prepare($sql);

    // Check if the statement preparation was successful
    if ($stmt) {
        // Bind parameters to the prepared statement
        $stmt->bind_param("ssssssss", $location, $type, $service, $sub_service, $mobile_no, $date, $time, $brand);

        // Execute the statement
        if ($stmt->execute()) {
            echo "New record created successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Failed to prepare the SQL query: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>
