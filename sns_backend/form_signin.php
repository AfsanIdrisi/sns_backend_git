<?php
header('Access-Control-Allow-Origin: *'); // Allow all origins; restrict in production
header('Access-Control-Allow-Methods: POST, GET, OPTIONS'); // Allowed methods
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With'); // Allowed headers
header('Content-Type: application/json');

include('db_connection.php'); // Include database connection

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0); // Allow the preflight request to succeed
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get and decode JSON input
    $inputData = file_get_contents('php://input');
    $data = json_decode($inputData, true);

    // Validate input
    if (!isset($data['phone'], $data['password'])) {
        echo json_encode([
            "success" => false,
            "message" => "Invalid input data."
        ]);
        exit;
    }

    $mobileno = $data['phone'];
    $password = $data['password'];

    // Validate mobile number format
    if (!preg_match('/^\d{10}$/', $mobileno)) {
        echo json_encode([
            "success" => false,
            "message" => "Invalid mobile number format. Must be 10 digits."
        ]);
        exit;
    }

    // Add country code to mobile number
    $mobilenoWithCountryCode = '+91' . $mobileno;

    // Fetch user record from the database
    // $query = "SELECT * FROM user_cred";
    $query = "SELECT * FROM user_cred WHERE mobile_no = '$mobileno'";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        echo json_encode([
            "success" => false,
            "message" => "Database error: " . $conn->error
        ]);
        exit;
    }

    // $stmt->bind_param("s", $mobilenoWithCountryCode);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        // User not found
        echo json_encode([
            "success" => false,
            "message" => "User not found. Please sign up."
        ]);
    } else {
        // User exists, validate password
        $user = $result->fetch_assoc();

        if ($password === $user['pass']) { // Replace with proper hashing (e.g., `password_verify`) for security
            // Successful login, send complete user data
            echo json_encode([
                "success" => true,
                "message" => "Login successful!",
                "data" => $user // Send all user data from the row
            ]);
        } else {
            // Incorrect password
            echo json_encode([
                "success" => false,
                "message" => "Incorrect password."
            ]);
        }
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo json_encode([
        "success" => false,
        "message" => "Invalid request method."
    ]);
}
?>
