<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Linking to external stylesheet -->
  <link rel="stylesheet" type="text/css" href="style.css" title="style 1" media="screen, tv, projection, handheld, print"/>
  <!-- Defining character encoding -->
  <meta charset="utf-8">
  <!-- Setting viewport for responsive design -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Our Transactions</title>
  <style>
    /* CSS styles */
    a {
      padding: 10px;
      color: white;
      background-color: skyblue;
      text-decoration: none;
      margin-right: 15px;
    }

    a:visited {
      color: purple;
    }

    a:link {
      color: brown; /* Changed to lowercase */
    }

    a:hover {
      background-color: white;
    }

    a:active {
      background-color: red;
    }

    button.btn {
      margin-left: 15px; /* Adjust this value as needed */
      margin-top: 4px;
    }

    input.form-control {
      /* Adjusted margin-left value */
      margin-left: 15px;
      padding: 8px;
    }

    section {
      padding: 71px;
      border-bottom: 1px solid #ddd;
    }

    footer {
      text-align: center;
      padding: 15px;
      background-color: darkgray;
    }

  </style>
  <!-- JavaScript validation and content load for insert data-->
  <script>
    function confirmInsert() {
      return confirm('Are you sure you want to insert this record?');
    }
  </script>
</head>

<body style="background-color: orange;">
<header>
  <form class="d-flex" role="search" action="search.php">
    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="query">
    <button class="btn btn-outline-success" type="submit">Search</button>
  </form>
  <ul style="list-style-type: none; padding: 0;">
    <li style="display: inline; margin-right: 10px;">
      <img src="./Images/Advice.AVIF" width="90" height="60" alt="Logo">
    </li>
    <li style="display: inline; margin-right: 10px;"><a href="./home.html">HOME</a></li>
    <li style="display: inline; margin-right: 10px;"><a href="./about.html">ABOUT</a></li>
    <li style="display: inline; margin-right: 10px;"><a href="./contact.html">CONTACT</a></li>
    
    <li style="display: inline; margin-right: 10px;"><a href="./advisors.php">ADVISORS</a></li>
    <li style="display: inline; margin-right: 10px;"><a href="./analytics.php">ANALYTICS</a></li>
    <li style="display: inline; margin-right: 10px;"><a href="./transaction.php">TRANSACTION</a></li>
    <li style="display: inline; margin-right: 10px;"><a href="./clients.php">CLIENTS</a></li>
    <li style="display: inline; margin-right: 10px;"><a href="./comments.php">COMMENTS</a></li>
    <li style="display: inline; margin-right: 10px;"><a href="./investmentproducts.php">INVESTMENTPRODUCTS</a></li>
    <li style="display: inline; margin-right: 10px;"><a href="./newsarticles.php">NEWSARTICLES</a></li>
    <li style="display: inline; margin-right: 10px;"><a href="./recommendation.php">RECOMMENDATION</a></li>
    <li style="display: inline; margin-right: 10px;"><a href="./watchlist.php">WATCHLIST</a></li>
    
    <li style="display: inline; margin-right: 10px;"><a href="./order.php">ORDERS</a></li>
    <li class="dropdown" style="display: inline; margin-right: 10px;">
      <a href="#" style="padding: 10px; color: white; background-color: skyblue; text-decoration: none; margin-right: 15px;">Settings</a>
      <div class="dropdown-contents">
        <!-- Links inside the dropdown menu -->
        <a href="login.html">Login</a>
        <a href="register.html">Register</a>
        <a href="logout.php">Logout</a>
      </div>
    </li>
  </ul>
</header>
<section>
  <h1><u>Transaction Form</u></h1> 

  <form method="post" onsubmit="return confirmInsert();">
    <label for="transaction_id">Transaction ID:</label>
    <input type="number" id="transaction_id" name="transaction_id"><br><br>

    <label for="user_id">user_id:</label>
    <input type="number" id="user_id" name="user_id" required><br><br>

    <label for="transaction_type">Transaction Type:</label>
    <input type="text" id="transaction_type" name="transaction_type" required><br><br>

    <label for="amount">Amount:</label>
    <input type="number" id="amount" name="amount" required><br><br>

    <label for="transaction_date">Transaction Date:</label>
    <input type="date" id="transaction_date" name="transaction_date" required><br><br>

    <input type="submit" name="add" value="Insert">
    <a href="./home.html">Go Back to Home</a>
  </form>
</section>

<?php
// PHP code for database insertion

include('database_connection.php');
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Prepare and bind the parameters
    $stmt = $connection->prepare("INSERT INTO transactions (transaction_id, user_id, amount, transaction_date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $transaction_id, $user_id, $amount, $transaction_date);
  

    $transaction_id = $_POST['transaction_id'];
    $user_id = $_POST['user_id'];
    $transaction_type = $_POST['transaction_type'];
    $amount = $_POST['amount'];
    $transaction_date = $_POST['transaction_date'];

    if ($stmt->execute()) {
        echo "New record has been added successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
$connection->close();
?>


  <center><h2>Table of transactions</h2></center>
  <table border="5">
    <tr>
      <th>Transaction ID</th>
      <th>user_id</th>
      <th>Transaction Type</th>
      <th>Amount</th>
      <th>Transaction Date</th>
      <th>Delete</th>
      <th>Update</th>
    </tr>
    <?php
    $host = "localhost";
    $user = "root";
    $pass = "";
    $database = "investment_advice_platform";

    $connection = new mysqli($host, $user, $pass, $database);
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    $sql = "SELECT * FROM transactions";
    $result = $connection->query($sql);

    if ($result) {
      if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
              $transaction_id = $row['transaction_id'];
              echo "<tr> 
                  <td>" . $row['transaction_id'] . "</td>
                  <td>" . $row['user_id'] . "</td>
                  <td>" . $row['transaction_type'] . "</td>
                  <td>" . $row['amount'] . "</td>
                  <td>" . $row['transaction_date'] . "</td>
                  <td><a style='padding:4px' href='delete_transaction.php?transaction_id=$transaction_id'>Delete</a></td> 
                  <td><a style='padding:4px' href='update_transaction.php?transaction_id=$transaction_id'>Update</a></td> 
              </tr>";
          }
      } else {
          echo "<tr><td colspan='7'>No data found</td></tr>";
      }
    } else {
      echo "Error: " . $connection->error;
    }

    $connection->close();
    ?>
  </table>
  <
</section>

<footer>
  <center><b><h2>UR CBE BIT &copy; 2024 &reg; Designed by: @Yvonne Imaniragena</h2></b></center>
</footer>

</body>
</html>
