<?php
header('Access-Control-Allow-Origin: *'); // Allow all origins; restrict in production
header('Access-Control-Allow-Methods: POST, GET, OPTIONS'); // Allowed methods
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With'); // Allowed headers
header('Content-Type: application/json');
include('db_connection.php'); // Include database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get input data from JSON
    $inputData = file_get_contents('php://input');
    $data = json_decode($inputData, true);

    // Validate input data
    if (!isset($data['username'], $data['phone'], $data['password'])) {
        echo json_encode([
            "success" => false,
            "message" => "Invalid input data."
        ]);
        exit;
    }

     $fullname = $data['username'];
    $mobileno = $data['phone'];
    $password = $data['password'];
   
   
    if (!preg_match('/^\d{10}$/', $mobileno)) {
        echo json_encode(value: [
            "success" => false,
            "message" => "Mobile number must be exactly 10 digits."
        ]);
        exit;
    }

        // Add country code to mobile number
        $mobilenoWithCountryCode = '+91' . $mobileno;

    // Check for duplicate mobile number
    $checkSql = "SELECT * FROM user_cred WHERE mobile_no = ?";
    $stmt = $conn->prepare($checkSql);
    $stmt->bind_param("s", $mobileno);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode([
            "success" => false,
            "message" => "Data already exists."
        ]);
    } else {
        // Insert new record
        $insertSql = "INSERT INTO user_cred (fullname, mobile_no, pass) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insertSql);
        $stmt->bind_param("sss", $fullname, $mobileno, $password);

        if ($stmt->execute()) {
            // echo json_encode([
            //     "success" => true,
            //     "message" => "New record created successfully!"

            // ]);
            // $sql = "SELECT * FROM user_cred WHERE mobile_no = '$mobileno.'";
            // $stmt1 = $conn->prepare($sql);
            // $stmt1->bind_param("sss",$mobileno);
            // $stmt1->execute();
            // $result1 = $stmt1->get_result();

            // $user1 = $result1->fetch_assoc();
            $user1=json_encode([
                "success" => true,
                "fullname" => $fullname,
                "phone" => $mobileno,

            ]);
            // echo json_encode([
            //     "success" => true,
            //     "message" => "New record created successfully",
            //     "user" => $user1

            // ]);
            echo $user1;
            
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Error inserting data: " . $stmt->error
            ]);
        }
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>