<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Linking to external stylesheet -->
  <link rel="stylesheet" type="text/css" href="style.css" title="style 1" media="screen, tv, projection, handheld, print"/>
  <!-- Defining character encoding -->
  <meta charset="utf-8">
  <!-- Setting viewport for responsive design -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Our newsarticles</title>
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
  <li style="display: inline; margin-right: 10px;"><a href="./recommendation.php">RECOMMENDATIONS</a>
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
  <h1>newsarticles Form</h1>
   <form method="post" onsubmit="return confirmInsert();">
  <form method="post">
    <label for="article_id">article_id:</label>
    <input type="number" id="article_id" name="article_id" required><br><br>

    <label for="title">title:</label>
    <input type="text" id="title" name="title" required><br><br>

    <label for="author">author:</label>
    <input type="text" id="author" name="author" required><br><br>

    <label for="publication_date">publication_date:</label>
    <input type="date" id="publication_date" name="publication_date" required><br><br>

    <label for="content">content:</label>
    <input type="text" id="content" name="content" required><br><br>

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
    $stmt = $connection->prepare("INSERT INTO newsarticles (article_id, title, author, publication_date, content) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $article_id, $title, $author, $publication_date, $content);
  
    // Set parameters and execute
    $article_id = $_POST['article_id'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $publication_date = $_POST['publication_date'];
    $content = $_POST['content'];

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
  <center><h2>Table of newsarticles</h2></center>
  <table border="5">
    <tr>
      <th>article_id</th>
      <th>title</th>
      <th>author</th>
      <th>publication_date</th>
      <th>content</th>
      <th>Delete</th>
      <th>Update</th>
    </tr>
    <?php
    // Define connection parameters
    include('database_connection.php');

    // Prepare SQL query to retrieve all orders
    $sql = "SELECT * FROM newsarticles";
    $result = $connection->query($sql);

    // Check if there are any orders
    if ($result->num_rows > 0) {
        // Output data for each row
        while ($row = $result->fetch_assoc()) {
            $article_id = $row['article_id']; // Fetch the ID
            echo "<tr>
                <td>" . $row['article_id'] . "</td>
                <td>" . $row['title'] . "</td>
                <td>" . $row['author'] . "</td>
                <td>" . $row['publication_date'] . "</td>
                <td>" . $row['content'] . "</td>
                
                <td><a style='padding:4px' href='delete_newsarticles.php?article_id=$article_id'>Delete</a></td> 
                <td><a style='padding:4px' href='update_newsarticles.php?article_id=$article_id'>Update</a></td> 
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
  