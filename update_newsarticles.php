<?php
// Connection details
include('database_connection.php');

// Check if article_id is set
if(isset($_REQUEST['article_id'])) {
    $article_id = $_REQUEST['article_id'];
    
    $stmt = $connection->prepare("SELECT * FROM newsarticles WHERE article_id=?");
    $stmt->bind_param("i", $article_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $y = $row['title'];
        $z = $row['author'];
        $w = $row['publication_date'];
        $o = $row['content'];
    } else {
        echo "News article not found.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Update news articles</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <center>
        <!-- Update products form -->
        <h2><u>Update Form of News Articles</u></h2>
        <form method="POST" onsubmit="return confirmUpdate();">
            <label for="title">Title:</label>
            <input type="text" name="title" value="<?php echo isset($y) ? $y : ''; ?>">
            <br><br>

            <label for="author">Author:</label>
            <input type="text" name="author" value="<?php echo isset($z) ? $z : ''; ?>">
            <br><br>

            <label for="publication_date">Publication Date:</label>
            <input type="date" name="publication_date" value="<?php echo isset($w) ? $w : ''; ?>">
            <br><br>

            <label for="content">Content:</label>
            <input type="text" name="content" value="<?php echo isset($o) ? $o : ''; ?>">
            <br><br>
            <input type="hidden" name="article_id" value="<?php echo $article_id; ?>"> <!-- Add a hidden input field for article_id -->
            <input type="submit" name="up" value="Update">
        </form>
    </center>
</body>
</html>

<?php
if(isset($_POST['up'])) {
    // Retrieve updated values from form
    $article_id = $_POST['article_id'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $publication_date = $_POST['publication_date'];
    $content = $_POST['content'];
    
    // Update the news article in the database
    $stmt = $connection->prepare("UPDATE newsarticles SET title=?, author=?, publication_date=?, content=? WHERE article_id=?");

    $stmt->bind_param("sssss", $title, $author, $publication_date, $content, $article_id);
    $stmt->execute();
    
    // Redirect to newsarticles.php
    header('Location: newsarticles.php');
    exit(); // Ensure that no other content is sent after the header redirection
}
?>
