<?php
include('Database_Connection.php');

// Check if watchlist_id is set
if(isset($_REQUEST['watchlist_id'])) {
    $watchlist_id = $_REQUEST['watchlist_id'];
    
    // Prepare and execute the DELETE statement
    $stmt = $connection->prepare("DELETE FROM watchlist WHERE watchlist_id=?");
    $stmt->bind_param("i", $watchlist_id);
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Delete Record</title>
        <script>
            function confirmDelete() {
                return confirm("Are you sure you want to delete this record?");
            }
        </script>
    </head>
    <body>
        <form method="post" onsubmit="return confirmDelete();">
            <input type="hidden" name="watchlist_id" value="<?php echo $watchlist_id; ?>">
            <input type="submit" value="Delete">
        </form>

        <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($stmt->execute()) {
        echo "Record deleted successfully.<br><br>
             <a href='watchlist.php'>Back To watchlists</a>";
    } else {
        echo "Error deleting data: " . $stmt->error;
    }
}
?>
    </body>
    </html>
    <?php
    $stmt->close();
} else {
    echo "watchlist_id is not set.";
}

$connection->close();
?>