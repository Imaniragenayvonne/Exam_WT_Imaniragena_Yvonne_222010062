<?php
include('database_connection.php');

// Check if recommendation_id is set
if(isset($_REQUEST['recommendation_id'])) {
    $recommendation_id = $_REQUEST['recommendation_id'];
    
    $stmt = $connection->prepare("SELECT * FROM recommendations WHERE recommendation_id=?");
    if($stmt) {
        $stmt->bind_param("i", $recommendation_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $y = $row['user_id'];
            $z = $row['advisor_id'];
            $w = $row['recommendation_text'];
            $o = $row['recommendation_date'];
        } else {
            echo "Recommendation not found.";
        }
    } else {
        echo "Error in preparing SQL statement.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Recommendation</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <center>
        <!-- Update recommendation form -->
        <h2><u>Update Form of Recommendation</u></h2>
        <form method="POST" onsubmit="return confirmUpdate();">
            <!-- Hidden input for recommendation_id -->
            <input type="hidden" name="recommendation_id" value="<?php echo isset($recommendation_id) ? $recommendation_id : ''; ?>">
            
            <label for="user_id">user_id:</label>
            <input type="number" name="user_id" value="<?php echo isset($y) ? $y : ''; ?>">
            <br><br>

            <label for="advisor_id">Advisor ID:</label>
            <input type="text" name="advisor_id" value="<?php echo isset($z) ? $z : ''; ?>">
            <br><br>

            <label for="recommendation_text">Recommendation Text:</label>
            <input type="text" name="recommendation_text" value="<?php echo isset($w) ? $w : ''; ?>">
            <br><br>

            <label for="recommendation_date">Recommendation Date:</label>
            <input type="date" name="recommendation_date" value="<?php echo isset($o) ? $o : ''; ?>">
            <br><br>
            
            <input type="submit" name="up" value="Update">
        </form>
    </center>
</body>
</html>

<?php
if(isset($_POST['up'])) {
    // Retrieve updated values from form
    $recommendation_id = $_POST['recommendation_id']; // Retrieve recommendation_id
    $user_id = $_POST['user_id'];
    $advisor_id = $_POST['advisor_id'];
    $recommendation_text = $_POST['recommendation_text'];
    $recommendation_date = $_POST['recommendation_date'];

    // Update the recommendation in the database
    $stmt = $connection->prepare("UPDATE recommendations SET user_id=?, advisor_id=?, recommendation_text=?, recommendation_date=? WHERE recommendation_id=?");
    if($stmt) {
        $stmt->bind_param("ssssi", $user_id, $advisor_id, $recommendation_text, $recommendation_date, $recommendation_id);
        $stmt->execute();
        
        // Redirect to recommendation.php
        header('Location: recommendation.php');
        exit(); // Ensure that no other content is sent after the header redirection
    } else {
        echo "Error in preparing SQL statement.";
    }
}
?>
