<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Linking to external stylesheet -->
  <link rel="stylesheet" type="text/css" href="style.css" title="style 1" media="screen, tv, projection, handheld, print"/>
  <!-- Defining character encoding -->
  <meta charset="utf-8">
  <!-- Setting viewport for responsive design -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Our investmentproducts</title>
  <style>
    /* Normal link */
    a {
      padding: 10px;
      color: white;
      background-color: mango;
      text-decoration: none;
      margin-right: 15px;
    }

    /* Visited link */
    a:visited {
      color: purple;
    }

    /* Unvisited link */
    a:link {
      color: brown; /* Changed to lowercase */
    }

    /* Hover effect */
    a:hover {
      background-color: white;
    }

    /* Active link */
    a:active {
      background-color: red;
    }

    /* Extend margin left for search button */
    button.btn {
      margin-left: 15px; /* Adjust this value as needed */
      margin-top: 4px;
    }

    /* Extend margin left for search button */
    input.form-control {
      margin-left: 15px; /* Adjust this value as needed */
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
<body style="background-color: skyblue;">
<header>
  <form class="d-flex" role="search" action="search.php">
    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="query">
    <button class="btn btn-outline-success" type="submit">Search</button>
  </form>
  <ul style="list-style-type: none; padding: 0;">
    <li style="display: inline; margin-right: 10px;">
      <img src="./Images/Advice.AVIF" width="90" height="60" alt="Logo">
    </li>
    <li style="display: inline; margin-right: 10px;"><a href="./home.html">HOME</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./about.html">ABOUT</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./contact.html">CONTACT</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./advisors.php">ADVISORS</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./analytics.php">ANALYTICS</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./transaction.php">TRANSACTION</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./clients.php">CLIENTS</a>
  </li>
  <li style="display: inline; margin-right: 10px;"><a href="./comments.php">COMMENTS</a>
  </li>
  <li style="display: inline; margin-right: 10px;"><a href="./investmentproducts.php">INVESTMENTPRODUCTS</a>
  </li>
  <li style="display: inline; margin-right: 10px;"><a href="./newsarticles.php">NEWSARTICLES</a>
  </li>
  <li style="display: inline; margin-right: 10px;"><a href="./recommendation.php">RECOMMENDATION</a>
  </li>
  <li style="display: inline; margin-right: 10px;"><a href="./watchlist.php">WATCHLIST</a>
  </li>
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
  <h1>investmentproducts Form</h1>
   <form method="post" onsubmit="return confirmInsert();">
  <form method="post">
    <label for="product_id">product_id:</label>
    <input type="number" id="product_id" name="product_id" required><br><br>

    <label for="product_name">product_name:</label>
    <input type="name" id="product_name" name="product_name" required><br><br>

    <label for="category">category:</label>
    <input type="text" id="category" name="category" required><br><br>

    <label for="description">description:</label>
    <input type="text" id="description" name="description" required><br><br>

    <label for="price">price:</label>
    <input type="number" id="price" name="price" required><br><br>

    <input type="submit" name="add" value="Insert">
    <a href="./home.html">Go Back to Home</a>
  </form>
</section>

<?php
// Connection details
include('database_connection.php');
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Prepare and bind the parameters
    $stmt = $connection->prepare("INSERT INTO investmentproducts (product_id, product_name, category, description, price) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $product_id, $product_name, $category, $description, $price);
  
    // Set parameters and execute
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    if ($stmt->execute()) {
        echo "New record has been added successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
$connection->close();
?>

<section>
  <center><h2>Table of investmentproducts</h2></center>
  <table border="5">
    <tr>
      <th>product_id</th>
      <th>product_name</th>
      <th>category</th>
      <th>description</th>
      <th>price</th>
      <th>Delete</th>
      <th>Update</th>
    </tr>
    <?php
    // Define connection parameters
    $host = "localhost";
    $user = "root";
    $pass = "";
    $database = "investment_advice_platform";


    // Establish a new connection
    $connection = new mysqli($host, $user, $pass, $database);

    // Check if connection was successful
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    // Prepare SQL query to retrieve all orders
    $sql = "SELECT * FROM investmentproducts";
    $result = $connection->query($sql);

    // Check if there are any orders
    if ($result->num_rows > 0) {
        // Output data for each row
        while ($row = $result->fetch_assoc()) {
            $product_id = $row['product_id']; // Fetch the ID
            echo "<tr>
                <td>" . $row['product_id'] . "</td>
                <td>" . $row['product_name'] . "</td>
                <td>" . $row['category'] . "</td>
                <td>" . $row['description'] . "</td>
                <td>" . $row['price'] . "</td>
                
                <td><a style='padding:4px' href='delete_investmentproducts.php?product_id=$product_id'>Delete</a></td> 
                <td><a style='padding:4px' href='update_investmentproducts.php?product_id=$product_id'>Update</a></td> 
            </tr>";
        }
    } else {
        echo "<tr><td colspan='7'>No data found</td></tr>";
    }
    // Close the database connection
    $connection->close();
    ?>
  </table>
</section>

<footer>
  <center><b><h2>UR CBE BIT &copy; 2024 &reg; Designed by: @Yvonne Imaniragena</h2></b></center>
</footer>

</body>
</html>
  