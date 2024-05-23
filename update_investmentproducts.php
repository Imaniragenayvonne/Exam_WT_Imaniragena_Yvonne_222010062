<?php
// Connection details
include('database_connection.php');

// Check if product_id is set
if(isset($_REQUEST['product_id'])) {
    $product_id = $_REQUEST['product_id'];
    
    $stmt = $connection->prepare("SELECT * FROM investmentproducts WHERE product_id=?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $y = $row['product_name'];
        $z = $row['category'];
        $w = $row['description'];
        $o = $row['price'];
    } else {
        echo "Investment product not found.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Update Investment Product</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <center>
        <!-- Update product form -->
        <h2><u>Update Form of Investment Product</u></h2>
        <form method="POST" onsubmit="return confirmUpdate();">
            <label for="product_name">Product Name:</label>
            <input type="text" name="product_name" value="<?php echo isset($y) ? $y : ''; ?>">
            <br><br>

            <label for="category">Category:</label>
            <input type="text" name="category" value="<?php echo isset($z) ? $z : ''; ?>">
            <br><br>

            <label for="description">Description:</label>
            <input type="text" name="description" value="<?php echo isset($w) ? $w : ''; ?>">
            <br><br>

            <label for="price">Price:</label>
            <input type="number" name="price" value="<?php echo isset($o) ? $o : ''; ?>">
            <br><br>

            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>"> <!-- Add a hidden input field for product_id -->
            <input type="submit" name="up" value="Update">
        </form>
    </center>
</body>
</html>

<?php
if(isset($_POST['up'])) {
    // Retrieve updated values from form
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    
    // Update the product in the database
    $stmt = $connection->prepare("UPDATE investmentproducts SET product_name=?, category=?, description=?, price=? WHERE product_id=?");
    $stmt->bind_param("ssssi", $product_name, $category, $description, $price, $product_id);
    $stmt->execute();
    
    // Redirect to investmentproducts.php
    header('Location: investmentproducts.php');
    exit(); // Ensure that no other content is sent after the header redirection
}
?>
