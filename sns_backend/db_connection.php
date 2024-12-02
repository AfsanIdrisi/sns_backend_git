<?php
// Allow cross-origin requests from any domain (for public access)
// Allow from any origin (including any port)


header('Access-Control-Allow-Origin: *'); // Allow all origins
header('Access-Control-Allow-Methods: POST, GET, OPTIONS'); // Allowed request methods
header('Access-Control-Allow-Headers: Content-Type, Authorization'); // Allowed headers


// Handle preflight requests (OPTIONS)
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    // Return a successful response to preflight requests
    header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
    header('Access-Control-Allow-Origin: *');
    exit(0);
}
 // Allow headers


// Database connection details
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "solution"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
else{
    // echo true;
}

// Close the connection
// $conn->close();
?>
