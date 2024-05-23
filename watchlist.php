<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Linking to external stylesheet -->
  <link rel="stylesheet" type="text/css" href="style.css" title="style 1" media="screen, tv, projection, handheld, print"/>
  <!-- Defining character encoding -->
  <meta charset="utf-8">
  <!-- Setting viewport for responsive design -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Our watchlist</title>
  <style>
    /* Normal link */
    a {
      padding: 10px;
      color: white;
      background-color: orange;
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
      background-color: pink;
    }

    /* Active link */
    a:active {
      background-color: orange;
    }

    /* Extend margin left for search button */
    button.btn {
      margin-left: 15px; /* Adjust this value as needed */
      margin-top: 4px;
    }
    /* Extend margin left for search button */
    input.form-control {
      margin-left: 1200px; /* Adjust this value as needed */

      padding: 8px;
     
    }
    section{
    padding:71px;
    border-bottom: 1px solid #ddd;
    }
    footer{
    text-align: center;
    padding: 15px;
    background-color:darkgray;
    }

  </style>

  <!-- JavaScript validation and content load for insert data-->
        <script>
            function confirmInsert() {
                return confirm('Are you sure you want to insert this record?');
            }
        </script>
  </head>

  <header>

<body bgcolor="skyblue">
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
    </li><br><br>
    
    
    
  </ul>

</header>
<section>

 <h1><u>watchlist Form</u></h1>

 <form method="post" onsubmit="return confirmInsert();">
    <form method="post">
        
        <label for="watchlist_id">watchlist_id:</label>
        <input type="number" id="watchlist_id" name="watchlist_id" required><br><br>

        <label for="user_id">user_id:<user_id/label>
        <input type="number" id="user_id" name="user_id" required><br><br>

        <label for="product_id">product_id:</label>
        <input type="number" id="product_id" name="product_id" required><br><br>
        
        <label for="added_date">added_date:</label>
        <input type="date" id="added_date" name="added_date" required><br><br>

        <input type="submit" name="add" value="Insert">
        <a href="./home.html">Go Back to Home</a>
    </form>
    <?php
// Connection details

    include('database_connection.php');

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Prepare and bind the parameters
    $stmt = $connection->prepare("INSERT INTO  watchlist(watchlist_id, user_id, product_id, added_date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $watchlist_id, $user_id, $product_id, $added_date);
    // Set parameters and execute

    $watchlist_id = $_POST['watchlist_id'];
    $user_id = $_POST['user_id'];
    $product_id = $_POST['product_id'];
    $added_date = $_POST['added_date'];

    if ($stmt->execute() === TRUE) {
        echo "New record has been added successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
$connection->close();
?>

<?php
// Connection details
$host = "localhost";
$user = "root";
$pass = "";
$database = "investment_advice_platform";




// Creating connection
$connection = new mysqli($host, $user, $pass, $database);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
// SQL query to fetch data from the Product table
$sql = "SELECT * FROM watchlist";
$result = $connection->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Information of watchlist</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Table of watchlist Information</h2>
    <table>
        <tr>
            <th>watchlist_id</th>
            <th>user_id</th>
            <th>product_id</th>
            <th>added_date</th>
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

        // Prepare SQL query to retrieve all stores
        $sql = "SELECT * FROM watchlist";
        $result = $connection->query($sql);

       if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $watchlist_id = $row['watchlist_id'];
            echo "<tr>
                <td>" . $row['watchlist_id'] . "</td>
                <td>" . $row['user_id'] . "</td>
                <td>" . $row['product_id'] . "</td>
                <td>" . $row['added_date'] . "</td>

                <td><a style='padding:4px' href='delete_watchlist.php?watchlist_id=$watchlist_id'>Delete</a></td> 
                <td><a style='padding:4px' href='update_watchlist.php?watchlist_id=$watchlist_id'>Update</a></td> 
            </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No data found</td></tr>";
        }
        // Close the database connection
        $connection->close();
        ?>
    </table>
</body>

    </section>


  
<footer>
  <center> 
    <b><h2>UR CBE BIT &copy, 2024 &reg, Designer by: @Yvonne Imaniragena</h2></b>
  </center>
</footer>
</body>
</html>