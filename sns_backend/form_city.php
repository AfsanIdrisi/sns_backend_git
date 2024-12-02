<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<?php
// Include the database connection file
include('db_connection.php'); // Make sure db_connection.php is in the same directory or adjust the path

// Get the form data only when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inputData = file_get_contents('php://input');
    $data = json_decode($inputData, true);
    $mobile_no = $data['phone'];
    $location = $data['location'];
    $type = $data['type'];
    $brand = $data['brand'];
    $date = $data['date'];
    $service = $data['service'];
    $repairInspection = $data['repairInspection'];
    $time = $data['time'];
    
    echo $mobile_no;
    echo $location;
    echo $type;

    // Prepare the SQL query
    $sql = "INSERT INTO city_qotation (fullname, mobile_no,plan_type, datetime, city, locality, dest_locality, cust_required, shift_date, services) 
            VALUES ('$fullname', '$password', '$datetime', '$city', '$locality', '$dest_locality', '$cust_required', '$shift_date', '$services')";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close connection
    $conn->close();
}
?>

<!-- Form to gather user input -->
<form method="POST" action="form_submission.php">
    Full Name: <input type="text" name="fullname" required><br><br>
    Phoneno: <input type="mobile_no" name="mobile_no" required><br><br>
    Plantyoe: <input type="plan_type" name="plan_type" required><br><br>
    DateTime: <input type="datetime" name="datetime" required><br><br>
    City: <input type="text" name="city" required><br><br>
    Locality: <input type="text" name="locality" required><br><br>
    Destination Locality: <input type="text" name="dest_locality" required><br><br>
    Customer Required: <input type="text" name="cust_required" required><br><br>
    Shift Date: <input type="date" name="shift_date" required><br><br>
    Services: <input type="text" name="services" required><br><br>
    <input type="submit" value="Submit">
</form>

</body>
</html>
