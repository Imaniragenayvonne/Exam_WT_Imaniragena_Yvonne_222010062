<?php
// Check if the 'query' GET parameter is set
if (isset($_GET['query']) && !empty($_GET['query'])) {
    // Connection details
    include('database_connection.php');


    // Sanitize input to prevent SQL injection
    $searchTerm = $connection->real_escape_string($_GET['query']);

    // Queries for different tables
    $queries = [
        'Advisors' => "SELECT specialization FROM Advisors WHERE specialization LIKE '%$searchTerm%'",
        'Recommendations' => "SELECT recommendation_text FROM Recommendations WHERE recommendation_text LIKE '%$searchTerm%'",
        'Transactions' => "SELECT amount FROM Transactions WHERE amount LIKE '%$searchTerm%'",
        'Clients' => "SELECT client_name FROM Clients WHERE client_name LIKE'%$searchTerm%'",
        'InvestmentProducts' => "SELECT description FROM InvestmentProducts WHERE description LIKE '%$searchTerm%'",
         'NewsArticles' => "SELECT author FROM NewsArticles WHERE author LIKE '%$searchTerm%'",
          'Comments' => "SELECT comment_text FROM Comments WHERE comment_text LIKE '%$searchTerm%'",
           'Analytics' => "SELECT page_visited FROM Analytics WHERE page_visited LIKE '%$searchTerm%'",
            'Watchlist' => "SELECT added_date FROM Watchlist WHERE added_date LIKE '%$searchTerm%'",
    ];

    // Output search results
    echo "<h2><u>Search Results:</u></h2>";

    foreach ($queries as $table => $sql) {
        $result=$connection->query($sql);
        echo "<h3>Table of $table:</h3>";
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<p>" . $row[array_keys($row)[0]] . "</p>"; // Dynamic field extraction from result
            }
        } else {
            echo "<p>No results found in $table matching the search term: '$searchTerm'</p>";
        }
    }

    // Close the connection
    $connection->close();
} else {
    echo "<p>No search term was provided.</p>";
}
?>
