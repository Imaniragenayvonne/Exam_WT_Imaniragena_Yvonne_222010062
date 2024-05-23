<?php
// Connection details
$host = "localhost";
$user = "root";
$pass = "";
$database = "investment_advice_platform";

// Creating connection
$connection = new mysqli($host, $user, $pass, $database);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Handling POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieving form data
    $fname  = $_POST['fname'];
    $lname = $_POST['lname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $activation_code = $_POST['activation_code'];
    
    // Preparing SQL query with prepared statements
    $sql = "INSERT INTO users (firstname, lastname, username, email, password, activation_code, is_activated) 
    VALUES (?, ?, ?, ?, ?, ?, 0)"; // Assuming is_activated default to 0

    // Preparing the statement
    $stmt = $connection->prepare($sql);

    // Binding parameters and executing the statement
    $stmt->bind_param("ssssss", $fname, $lname, $username, $email, $password, $activation_code);
    
    if ($stmt->execute()) {
        // Redirecting to login page on successful registration
        header("Location: login.html");
        exit();
    } else {
        // Displaying error message if query execution fails
        echo "Error: " . $sql . "<br>" . $stmt->error;
    }
}

// Closing database connection
$connection->close();
?>
