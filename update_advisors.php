<?php
// Connection details
include('database_connection.php');

// Check if advisor_id is set
if(isset($_REQUEST['advisor_id'])) {
    $advisor_id = $_REQUEST['advisor_id'];
    
    // Prepare the SQL statement
    $stmt = $connection->prepare("SELECT * FROM advisors WHERE advisor_id=?");
    $stmt->bind_param("i", $advisor_id);
    $stmt->execute();
    $result = $stmt->get_result();
        
        // Check if there are rows in the result
        if($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $y = $row['advisor_name'];
            $z = $row['specialization'];
            $w = $row['contact_number'];
        } else {
            echo "advisors not found.";
        }}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Update advisors</title>
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
        <h2><u>Update Form of advisors</u></h2>
        <form method="POST" onsubmit="return confirmUpdate();">
            <label for="advisor_name">advisor_name:</label>
            <input type="text" name="advisor_name" value="<?php echo isset($y) ? $y : ''; ?>">
            <br><br>

            <label for="specialization">specialization:</label>
            <input type="text" name="specialization" value="<?php echo isset($z) ? $z : ''; ?>">
            <br><br>

            <label for="contact_number">contact_number:</label>
            <input type="number" name="contact_number" value="<?php echo isset($w) ? $w : ''; ?>">
            <br><br>

            <input type="hidden" name="advisor_id" value="<?php echo $advisor_id; ?>"> <!-- Add a hidden input field for advisor_id -->
            <input type="submit" name="up" value="Update">
        </form>
    </center>
</body>
</html>

<?php
if(isset($_POST['up'])) {
    // Retrieve updated values from form
    $advisor_id = $_POST['advisor_id'];
    $advisor_name = $_POST['advisor_name'];
    $specialization = $_POST['specialization'];
    $contact_number = $_POST['contact_number'];
    
    // Update the advisors in the database
    $stmt = $connection->prepare("UPDATE advisors SET advisor_name=?, specialization=?, contact_number=? WHERE advisor_id=?");

        $stmt->bind_param("sssi", $advisor_name,$specialization, $contact_number,$advisor_id);
        $stmt->execute();
            // Redirect to advisors.php
            header('Location:advisors.php');
            exit(); // Ensure that no other content is sent after the header redirection
        }
?>
