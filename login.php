<?php
session_start(); // Starting the session

// Connection details
$host = "localhost";
$user = "root";
$pass = "";
$database = "investment_advice_platform"; // Removed spaces from the database name

// Create connection
$connection = new mysqli($host, $user, $pass, $database);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize user input
    $email = $connection->real_escape_string($_POST['email']); // Use real_escape_string instead of mysqli_real_escape_string

    // Hash the password (Assuming it's not hashed yet)
    $password = $_POST['password']; // Assuming the password is not hashed yet
    // Note: Password hashing should be done before storing it in the database

    // Prepare and execute SQL statement to prevent SQL injection
    $sql = "SELECT user_id, email, password FROM users WHERE email=?";
    $stmt = $connection->prepare($sql); 
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        // Verify the hashed password
        if (password_verify($password, $row['password'])) { // Verify hashed password
            $_SESSION['user_id'] = $row['user_id'];
            header("Location: home.html"); // Redirect to home page after successful login
            exit();
        } else {
            $error = "Invalid email or password"; // Set error message if password is incorrect
        }
    } else {
        $error = "User not found"; // Set error message if user does not exist
    }
    
    // Close result set
    $result->close();
    
    // Close statement
    $stmt->close();
}

// Close connection
$connection->close();
?>
