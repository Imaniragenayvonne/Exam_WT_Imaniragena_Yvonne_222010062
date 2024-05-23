<?php
include('Database_Connection.php');

// Check if recommendation_id is set
if(isset($_REQUEST['recommendation_id'])) {
    $recommendation_id = $_REQUEST['recommendation_id'];
    
    // Prepare and execute the DELETE statement
    $stmt = $connection->prepare("DELETE FROM recommendations WHERE recommendation_id=?");
    $stmt->bind_param("i", $recommendation_id);
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
            <input type="hidden" name="recommendation_id" value="<?php echo $recommendation_id; ?>">
            <input type="submit" value="Delete">
        </form>

        <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($stmt->execute()) {
        echo "Record deleted successfully.<br><br>
             <a href='recommendation.php'>Back To recommendations</a>";
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
    echo "recommendation_id is not set.";
}

$connection->close();
?>