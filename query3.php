<?php
require_once 'get-parameters.php';

// Example manual query: fetch countries with population > 1 million
try {
    $stmt = $pdo->query("SELECT name, population FROM countrydata_final WHERE population > 1000000");
    $results = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Manual Query Output</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h2>Countries with Population Over 1 Million</h2>
    <table border="1">
        <tr><th>Country</th><th>Population</th></tr>
        <?php foreach ($results as $row): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['name']); ?></td>
            <td><?php echo htmlspecialchars($row['population']); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <br>
    <p><a href="query.php">← Back to Query Page</a></p>
</body>
</html>