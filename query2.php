<?php
require_once 'get-parameters.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['selection'])) {
    $selection = $_POST['selection'];

    // Map query IDs to SQL statements
    $queries = [
        'Q1' => "SELECT name AS country, mobilephones FROM countrydata_final WHERE mobilephones IS NOT NULL",
        'Q2' => "SELECT name AS country, population FROM countrydata_final WHERE population IS NOT NULL",
        'Q3' => "SELECT name AS country, lifeexpectancy FROM countrydata_final WHERE lifeexpectancy IS NOT NULL",
        'Q4' => "SELECT name AS country, GDP FROM countrydata_final WHERE GDP IS NOT NULL",
        'Q5' => "SELECT name AS country, mortalityunder5 FROM countrydata_final WHERE mortalityunder5 IS NOT NULL"
    ];

    if (!array_key_exists($selection, $queries)) {
        die("Invalid selection.");
    }

    try {
        $stmt = $pdo->query($queries[$selection]);
        $results = $stmt->fetchAll();
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }

} else {
    die("No query selection received.");
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Query Results</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Query Results</h1>
    <p><a href="query.php">← Back to Query Page</a></p>

    <?php if (!empty($results)): ?>
        <table border="1">
            <tr>
                <?php foreach (array_keys($results[0]) as $col): ?>
                    <th><?php echo htmlspecialchars($col); ?></th>
                <?php endforeach; ?>
            </tr>
            <?php foreach ($results as $row): ?>
                <tr>
                    <?php foreach ($row as $value): ?>
                        <td><?php echo htmlspecialchars($value); ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No data found for your selection.</p>
    <?php endif; ?>
</body>
</html>