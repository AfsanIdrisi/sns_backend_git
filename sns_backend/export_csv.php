<?php
include('db_connection.php');

// Fetch data from the database
$sql = "SELECT * FROM shah"; // Replace with your table name
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Define the CSV file path
    $directory = "C:/Users/Mshah/Downloads"; // Replace with your desired directory
    $fileName = "shah_data_" . date("Y-m-d_H-i-s") . ".csv";
    $filePath = $directory . "/" . $fileName;

    // Open the file in write mode
    $file = fopen($filePath, "w");

    if ($file === false) {
        die("Failed to create the file at $filePath. Please check directory permissions.");
    }

    // Write the column headers
    $headers = ["ID", "Username", "Phone Number", "Prize"]; // Replace with your column names
    fputcsv($file, $headers);

    // Write the rows
    while ($row = $result->fetch_assoc()) {
        fputcsv($file, $row);
    }

    // Close the file
    fclose($file);

    echo "File successfully created at $filePath";
} else {
    echo "No records found.";
}

// Close the connection
$conn->close();
?>
