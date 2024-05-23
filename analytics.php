<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Linking to external stylesheet -->
  <link rel="stylesheet" type="text/css" href="style.css" title="style 1" media="screen, tv, projection, handheld, print"/>
  <!-- Defining character encoding -->
  <meta charset="utf-8">
  <!-- Setting viewport for responsive design -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Our analyticles</title>
  <style>
    /* CSS styles */
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
    .btn {
      margin-left: 15px; /* Adjust this value as needed */
      margin-top: 4px;
    }

    /* Extend margin left for form control */
    .form-control {
      margin-left: 15px; /* Adjust this value as needed */
      padding: 8px;
    }

    /* General section styling */
    section {
      padding: 20px; /* Reduced padding */
      border-bottom: 1px solid #ddd;
    }

    /* Footer styling */
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
    <!-- Navigation links -->
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
    <li style="display: inline; margin-right: 10px;"><a href="./recommendation.php">RECOMMENDATIONS</a></li>
    <li style="display: inline; margin-right: 10px;"><a href="./watchlist.php">WATCHLIST</a></li>
    <!-- Dropdown menu -->
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
  <h1>Analytics Form</h1>

  <form method="post" onsubmit="return confirmInsert();">
    <label for="analytics_id">analytics_id:</label>
    <input type="number" id="analytics_id" name="analytics_id" required><br><br>

    <label for="user_id">user_id:</label>
    <input type="number" id="user_id" name="user_id" required><br><br>

    <label for="page_visited">page_visited:</label>
    <input type="text" id="page_visited" name="page_visited" required><br><br>

    <label for="visit_date">visit_date:</label>
    <input type="date" id="visit_date" name="visit_date" required><br><br>

    <label for="time_spent">time_spent:</label>
    <input type="text" id="time_spent" name="time_spent" required><br><br>

    <input type="submit" name="add" value="Insert">
    <a href="./home.html">Go Back to Home</a>
  </form>
</section>

<?php
// Include database connection
include('database_connection.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Prepare and bind the parameters
    $stmt = $connection->prepare("INSERT INTO analytics (analytics_id, user_id, page_visited, visit_date, time_spent) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iisss", $analytics_id, $user_id, $page_visited, $visit_date, $time_spent);
    // Set parameters and execute
    $analytics_id = $_POST['analytics_id'];
    $user_id = $_POST['user_id'];
    $page_visited = $_POST['page_visited'];
    $visit_date = $_POST['visit_date'];
    $time_spent = $_POST['time_spent'];

    if ($stmt->execute()) {
        echo "New record has been added successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Establish database connection for displaying analytics table
include('database_connection.php');

// Prepare SQL query to retrieve all analytics
$sql = "SELECT * FROM analytics";
$result = $connection->query($sql);

// Check if there are any analytics
if ($result->num_rows > 0) {
    echo "<section>";
    echo "<center><h2>Table of analytics</h2></center>";
    echo "<table border='1'>";
    echo "<tr><th>analytics_id</th><th>user_id</th><th>page_visited</th><th>visit_date</th><th>time_spent</th><th>Delete</th><th>Update</th></tr>";

    // Output data for each row
    while ($row = $result->fetch_assoc()) {
        $analytics_id = $row['analytics_id']; // Fetch the ID
        echo "<tr> 
            <td>" . $row['analytics_id'] . "</td>
            <td>" . $row['user_id'] . "</td>
            <td>" . $row['page_visited'] . "</td>
            <td>" . $row['visit_date'] . "</td>
            <td>" . $row['time_spent'] . "</td>
            <td><a style='padding:4px' href='delete_analytics.php?analytics_id=$analytics_id'>Delete</a></td> 
            <td><a style='padding:4px' href='update_analytics.php?analytics_id=$analytics_id'>Update</a></td> 
        </tr>";
    }
    echo "</table>";
    echo "</section>";
} else {
    echo "<section>";
    echo "<center>No data found</center>";
    echo "</section>";
}

// Close the database connection
$connection->close();
?>

<footer>
  <center><b><h2>UR CBE BIT &copy; 2024 &reg; Designed by: @Yvonne Imaniragena</h2></b></center>
</footer>

</body>
</html>
