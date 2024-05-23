<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Linking to external stylesheet -->
  <link rel="stylesheet" type="text/css" href="style.css" title="style 1" media="screen, tv, projection, handheld, print"/>
  <!-- Defining character encoding -->
  <meta charset="utf-8">
  <!-- Setting viewport for responsive design -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Our Advisors</title>
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
  <h1>Advisors Form</h1>
  <form method="post" onsubmit="return confirmInsert();">
    <label for="advisor_id">Advisor ID:</label>
    <input type="number" id="advisor_id" name="advisor_id" required><br><br>

    <label for="advisor_name">Advisor Name:</label>
    <input type="text" id="advisor_name" name="advisor_name" required><br><br>

    <label for="specialization">Specialization:</label>
    <input type="text" id="specialization" name="specialization" required><br><br>

    <label for="contact_number">Contact Number:</label>
    <input type="number" id="contact_number" name="contact_number" required><br><br>

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
    $stmt = $connection->prepare("INSERT INTO advisors (advisor_id, advisor_name, specialization, contact_number) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $advisor_id, $advisor_name, $specialization, $contact_number);
    // Set parameters and execute
    $advisor_id = $_POST['advisor_id'];
    $advisor_name = $_POST['advisor_name'];
    $specialization = $_POST['specialization'];
    $contact_number = $_POST['contact_number'];

    if ($stmt->execute()) {
        echo "New record has been added successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Establish database connection for displaying advisors table
include('database_connection.php');

// Prepare SQL query to retrieve all advisors
$sql = "SELECT * FROM advisors";
$result = $connection->query($sql);

// Check if there are any advisors
if ($result->num_rows > 0) {
    echo "<section>";
    echo "<center><h2>Table of Advisors</h2></center>";
    echo "<table border='1'>";
    echo "<tr><th>Advisor ID</th><th>Advisor Name</th><th>Specialization</th><th>Contact Number</th><th>Delete</th><th>Update</th></tr>";

    // Output data for each row
    while ($row = $result->fetch_assoc()) {
        $advisor_id = $row['advisor_id']; // Fetch the ID
        echo "<tr> 
            <td>" . $row['advisor_id'] . "</td>
            <td>" . $row['advisor_name'] . "</td>
            <td>" . $row['specialization'] . "</td>
            <td>" . $row['contact_number'] . "</td>
            <td><a style='padding:4px' href='delete_advisors.php?advisor_id=$advisor_id'>Delete</a></td> 
            <td><a style='padding:4px' href='update_advisors.php?advisor_id=$advisor_id'>Update</a></td> 
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
