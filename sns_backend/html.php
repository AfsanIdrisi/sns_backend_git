<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Form Example</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        form {
            max-width: 400px;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            font-weight: bold;
        }
        input {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            padding: 10px 15px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <h2>Qotation Details</h2>
    <form action="" method="POST">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="phone">Phone Number:</label>
            <input type="tel" id="phone" name="phone" pattern="[0-9]{10}" required>
        </div>
        <div class="form-group">
            <label for="prize">Prize:</label>
            <input type="text" id="prize" name="prize" required>
        </div>
        <button type="submit">Submit</button>
    </form>

    <form action="export_csv.php" method="POST">
        <button type="submit">Export to CSV</button>
    </form>

    <?php
    include('db_connection.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['export_csv'])) {
        // Collect and sanitize form data
        $username = htmlspecialchars($_POST['username']);
        $phone = htmlspecialchars($_POST['phone']);
        $prize = htmlspecialchars($_POST['prize']);

        $sql = "INSERT INTO shah (username, phone_no, prize) 
            VALUES ('$username','$phone','$prize')";

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    ?>
</body>
</html>
