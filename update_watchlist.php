<?php
// Connection details
include('database_connection.php');

// Check if watchlist_id is set
if(isset($_REQUEST['watchlist_id'])) {
    $watchlist_id = $_REQUEST['watchlist_id'];
    
    $stmt = $connection->prepare("SELECT * FROM watchlist WHERE watchlist_id=?");
    $stmt->bind_param("i", $watchlist_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $x = $row['watchlist_id'];
        $y = $row['user_id'];
        $z = $row['product_id']; // Corrected column name
        $w = $row['added_date'];
    } else {
        echo "watchlist not watchlistfound.";
    }
}
?>
  
<!DOCTYPE html>
<html>
<head>
    <title>Update watchlist</title>
 <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body><center>
    <!-- Update products form -->
    <h2><u>Update Form of watchlist</u></h2>

    <form method="POST" onsubmit="return confirmUpdate();">
        <label for="user_id">user_id:</label>
        <input type="number" name="user_id" value="<?php echo isset($y) ? $y : ''; ?>">
        <br><br>
        <label for="product_id">product_id:</label>
        <input type="number" name="product_id" value="<?php echo isset($z) ? $z : ''; ?>"> <!-- Changed input type to text -->
        <br><br>

        <label for="added_date">added_date:</label>
        <input type="date" name="added_date" value="<?php echo isset($w) ? $w : ''; ?>">
        <br><br>

        <input type="hidden" name="watchlist_id" value="<?php echo $watchlist_id; ?>"> <!-- Added hidden input for watchlist_id -->
        <input type="submit" name="up" value="Update">
    </form>

<?php
if(isset($_POST['up'])) {
    // Retrieve updated values from form
    $user_id = $_POST['user_id'];
    $product_id = $_POST['product_id'];
    $added_date = $_POST['added_date'];
    
    // Update the store in the database
    $stmt = $connection->prepare("UPDATE watchlist SET user_id=?, product_id=?, added_date=? WHERE watchlist_id=?");
    $stmt->bind_param("sssi", $user_id, $product_id, $added_date, $watchlist_id);
    $stmt->execute();
    
    // Redirect to store.php
    header('Location: watchlist.php');
    exit(); // Ensure that no other content is sent after the header redirection
}
?>
</body>
</html>
