<?php
// Connection details
include('database_connection.php');

// Check if analytics_id is set
if(isset($_REQUEST['analytics_id'])) {
    $analytics_id = $_REQUEST['analytics_id']; 
    
    // Prepare the SQL statement
    $stmt = $connection->prepare("SELECT * FROM analytics WHERE analytics_id=?");
    $stmt->bind_param("i", $analytics_id);
    $stmt->execute();
    $result = $stmt->get_result();
        
        // Check if there are rows in the result
        if($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $y = $row['user_id'];
            $z = $row['page_visited'];
            $w = $row['visit_date'];
            $x = $row['time_spent'];
        } else {
            echo "analytics not found.";
        }}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Update analytics</title>
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
        <h2><u>Update Form of analytics</u></h2>
        <form method="POST" onsubmit="return confirmUpdate();">
            <label for="user_id">user_id:</label>
            <input type="number" name="user_id" value="<?php echo isset($y) ? $y : ''; ?>">
            <br><br>

            <label for="page_visited">page_visited:</label>
            <input type="text" name="page_visited" value="<?php echo isset($z) ? $z : ''; ?>">
            <br><br>

            <label for="visit_date">visit_date:</label>
            <input type="date" name="visit_date" value="<?php echo isset($w) ? $w : ''; ?>">
            <br><br>

            <label for="time_spent">time_spent:</label>
            <input type="text" name="time_spent" value="<?php echo isset($w) ? $w : ''; ?>">
            <br><br>

            <input type="hidden" name="analytics_id" value="<?php echo $analytics_id; ?>"> <!-- Add a hidden input field for analytics_id -->
            <input type="submit" name="up" value="Update">
        </form>
    </center>
</body>
</html>

<?php
if(isset($_POST['up'])) {
     
    // Retrieve updated values from form
    $analytics_id = $_POST['analytics_id'];
    $user_id = $_POST['user_id'];
    $page_visited = $_POST['page_visited'];
    $visit_date = $_POST['visit_date'];
    $time_spent = $_POST['time_spent'];
    
    // Update the analytics in the database
    $stmt = $connection->prepare("UPDATE analytics SET user_id=?, page_visited=?, visit_date=?, time_spent=? WHERE analytics_id=?");

        $stmt->bind_param("issss", $user_id, $page_visited, $visit_date, $time_spent,$analytics_id);
        $stmt->execute();
            // Redirect to analytics.php
            header('Location:analytics.php');
            exit(); // Ensure that no other content is sent after the header redirection
        }
?>
