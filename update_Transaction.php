<?php
// Connection details
include('database_connection.php');

// Check if transaction_id is set
if(isset($_REQUEST['transaction_id'])) {
    $transaction_id = $_REQUEST['transaction_id'];
    
    // Prepare the SQL statement
    $stmt = $connection->prepare("SELECT * FROM transactions WHERE transaction_id=?");
    $stmt->bind_param("i", $transaction_id);
    $stmt->execute();
    $result = $stmt->get_result();
        
        // Check if there are rows in the result
        if($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $y = $row['user_id'];
            $z = $row['transaction_type'];
            $w = $row['amount'];
            $x = $row['transaction_date'];
        } else {
            echo "Transaction not found.";
        }}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Update transaction</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <center>
        <!-- Update transaction form -->
        <h2><u>Update Form of transaction</u></h2>
        <form method="POST" onsubmit="return confirmUpdate();">
            <label for="user_id">user_id:</label>
            <input type="number" name="user_id" value="<?php echo isset($y) ? $y : ''; ?>">
            <br><br>

            <label for="transaction_type">Transaction Type:</label>
            <input type="text" name="transaction_type" value="<?php echo isset($z) ? $z : ''; ?>">
            <br><br>

            <label for="amount">Amount:</label>
            <input type="number" name="amount" value="<?php echo isset($w) ? $w : ''; ?>">
            <br><br>

            <label for="transaction_date">Transaction Date:</label>
            <input type="date" name="transaction_date" value="<?php echo isset($x) ? $x : ''; ?>">
            <br><br>

            <input type="hidden" name="transaction_id" value="<?php echo $transaction_id; ?>"> <!-- Add a hidden input field for transaction_id -->
            <input type="submit" name="up" value="Update">
        </form>
    </center>
</body>
</html>

<?php
if(isset($_POST['up'])) {
    // Retrieve updated values from form
    $transaction_id = $_POST['transaction_id'];
    $user_id = $_POST['user_id'];
    $transaction_type = $_POST['transaction_type'];
    $amount = $_POST['amount'];
    $transaction_date = $_POST['transaction_date'];
    
    // Update the transaction in the database
    $stmt = $connection->prepare("UPDATE transactions SET user_id=?, transaction_type=?, amount=?, transaction_date=? WHERE transaction_id=?");

        $stmt->bind_param("isssi", $user_id,$transaction_type, $amount, $transaction_date, $transaction_id);
        $stmt->execute();
            // Redirect to transaction.php
            header('Location:transaction.php');
            exit(); // Ensure that no other content is sent after the header redirection
        }
?>