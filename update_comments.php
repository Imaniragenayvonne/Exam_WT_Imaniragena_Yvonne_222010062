<?php
// Connection details
include('database_connection.php');

// Check if comment_id is set
if(isset($_REQUEST['comment_id'])) {
    $comment_id = $_REQUEST['comment_id']; 
    
    // Prepare the SQL statement
    $stmt = $connection->prepare("SELECT * FROM comments WHERE comment_id=?");
    $stmt->bind_param("i", $comment_id);
    $stmt->execute();
    $result = $stmt->get_result();
            
        // Check if there are rows in the result
        if($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $y = $row['user_id'];
            $z = $row['article_id'];
            $w = $row['comment_text'];
            $x = $row['comment_date'];
        } else {
            echo "comments not found.";
        }}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Update comments</title>
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
        <h2><u>Update Form of comments</u></h2>

        <form method="POST" onsubmit="return confirmUpdate();">
            
            <label for="user_id">user_id:</label>
            <input type="number" name="user_id" value="<?php echo isset($y) ? $y : ''; ?>">
            <br><br>


            <label for="article_id">article_id:</label>
            <input type="number" name="article_id" value="<?php echo isset($z) ? $z : ''; ?>">
            <br><br>

            <label for="comment_text">comment_text:</label>
            <input type="text" name="comment_text" value="<?php echo isset($w) ? $w : ''; ?>">
            <br><br>

            <label for="comment_date">comment_date:</label>
            <input type="date" name="comment_date" value="<?php echo isset($w) ? $w : ''; ?>">
            <br><br>

            <input type="hidden" name="comment_id" value="<?php echo $comment_id; ?>"> <!-- Add a hidden input field for comment_id -->
            <input type="submit" name="up" value="Update">
        </form>
    </center>
</body>
</html>

<?php
if(isset($_POST['up'])) {

    // Retrieve updated values from form
    $comment_id = $_POST['comment_id'];
    $user_id = $_POST['user_id'];
    $article_id = $_POST['article_id'];
    $comment_text = $_POST['comment_text'];
    $comment_date = $_POST['comment_date'];

    // Update the comments in the database
    $stmt = $connection->prepare("UPDATE comments SET user_id=?, article_id=?, comment_text=?, comment_date=? WHERE comment_id=?");

        $stmt->bind_param("iissi", $user_id, $article_id, $comment_text, $comment_date,$comment_id);
        $stmt->execute();
            // Redirect to comments.php
            header('Location:comments.php');
            exit(); // Ensure that no other content is sent after the header redirection
        }
?>
