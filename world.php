<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", 
                    $username, 
                    $password);

    $coun = isset($_GET['country']) ? $_GET['country'] : '';

    if ($coun !== '') {
       
        $stmt = $pdo->prepare("SELECT * FROM countries WHERE name LIKE 
:country");
        $stmt->bindValue(':country', "%$coun%");
    } else {
        
        $stmt = $pdo->prepare("SELECT * FROM countries");
    }

    $stmt->execute();
    $r = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
    exit;
}


if (!empty($r)) {
    echo "<table>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>Country Name</th>";
    echo "<th>Continent</th>";
    echo "<th>Independence Year</th>";
    echo "<th>Head of State</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    
    foreach ($r as $row) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['continent']) . "</td>";
        echo "<td>" . htmlspecialchars($row['independence_year']) . 
"</td>";
        echo "<td>" . htmlspecialchars($row['head_of_state']) . "</td>";
        echo "</tr>";
    }
    
    echo "</tbody>";
    echo "</table>";
} else {
    echo "<p>No countries found.</p>";
}
?>
