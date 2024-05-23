<?php
include('Database_Connection.php');

// Check if analytics_id is set
if(isset($_REQUEST['analytics_id'])) {
    $analytics_id = $_REQUEST['analytics_id'];
    
    // Prepare and execute the DELETE statement
    $stmt = $connection->prepare("DELETE FROM analytics WHERE analytics_id=?");
    $stmt->bind_param("i", $analytics_id);
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
            <input type="hidden" name="analytics_id" value="<?php echo $analytics_id; ?>">
            <input type="submit" value="Delete">
        </form>

        <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($stmt->execute()) {
        echo "Record deleted successfully.<br><br>
             <a href='analytics.php'>back to analytics list</a>";
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
    echo "analytics_id is not set.";
}

$connection->close();
?>