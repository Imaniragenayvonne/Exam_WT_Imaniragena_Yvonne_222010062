<?php
// Connection details
include('database_connection.php');

// Check if client_id is set
if(isset($_REQUEST['client_id'])) {
    $client_id = $_REQUEST['client_id']; 
    
    // Prepare the SQL statement
    $stmt = $connection->prepare("SELECT * FROM clients WHERE client_id=?");
    $stmt->bind_param("i", $client_id);
    $stmt->execute();
    $result = $stmt->get_result();
            
        // Check if there are rows in the result
        if($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $y = $row['client_name'];
            $z = $row['advisor_id'];
            $w = $row['contact_number'];
            $x = $row['email'];
        } else {
            echo "clients not found.";
        }}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Update clients</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <center>
        <!-- Update advisors form -->
        <h2><u>Update Form of clients</u></h2>

        <form method="POST" onsubmit="return confirmUpdate();">
            
            <label for="client_name">client_name:</label>
            <input type="text" name="client_name" value="<?php echo isset($y) ? $y : ''; ?>">
            <br><br>

            <label for="advisor_id">advisor_id:</label>
            <input type="number" name="advisor_id" value="<?php echo isset($z) ? $z : ''; ?>">
            <br><br>

            <label for="contact_number">contact_number:</label>
            <input type="number" name="contact_number" value="<?php echo isset($w) ? $w : ''; ?>">
            <br><br>

            <label for="email">email:</label>
            <input type="email" name="email" value="<?php echo isset($w) ? $w : ''; ?>">
            <br><br>

            <input type="hidden" name="client_id" value="<?php echo $client_id; ?>"> <!-- Add a hidden input field for client_id -->
            <input type="submit" name="up" value="Update">
        </form>
    </center>
</body>
</html>

<?php
if(isset($_POST['up'])) {

    // Retrieve updated values from form
    $client_id = $_POST['client_id'];
    $client_name = $_POST['client_name'];
    $advisor_id = $_POST['advisor_id'];
    $contact_number = $_POST['contact_number'];
    $email = $_POST['email'];
    
    // Update the clients in the database
    $stmt = $connection->prepare("UPDATE clients SET client_name=?, advisor_id=?, contact_number=?, email=? WHERE client_id=?");

        $stmt->bind_param("sssss", $client_name, $advisor_id, $contact_number, $email,$client_id);
        $stmt->execute();
            // Redirect to clients.php
            header('Location:clients.php');
            exit(); // Ensure that no other content is sent after the header redirection
        }
?>
