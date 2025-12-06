<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, 
$password);

   
    $coun = isset($_GET['country']) ? $_GET['country'] : '';
    $lookup = isset($_GET['lookup']) ? $_GET['lookup'] : '';

    if ($lookup === "cities") {
       
        if ($coun !== '') {
            $stmt = $pdo->prepare(
                "SELECT cities.name AS city_name, cities.district, cities.population
                 FROM cities
                 JOIN countries ON cities.country_code = countries.code
                 WHERE countries.name LIKE :country"
            );
            $stmt->bindValue(':country', "%$coun%");
        } else {
            $stmt = $pdo->prepare(
                "SELECT cities.name AS city_name, cities.district, cities.population
                 FROM cities
                 JOIN countries ON cities.country_code = countries.code"
            );
        }

        $stmt->execute();
        $r = $stmt->fetchAll(PDO::FETCH_ASSOC); 

        
        if (!empty($r)) {
            echo "<table>";
            echo "<thead>";
            echo "<tr><th>Name</th><th>District</th><th>Population</th></tr>";
            echo "</thead><tbody>";
            foreach ($r as $row) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['city_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['district']) . "</td>";
                echo "<td>" . htmlspecialchars($row['population']) . "</td>";
                echo "</tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<p>No cities found.</p>";
        }

    } else {
       
        if ($coun !== '') {
            $stmt = $pdo->prepare("SELECT * FROM countries WHERE name LIKE :country");
            $stmt->bindValue(':country', "%$coun%");
        } else {
            $stmt = $pdo->prepare("SELECT * FROM countries");
        }

        $stmt->execute();
        $r = $stmt->fetchAll(PDO::FETCH_ASSOC); 

       
        if (!empty($r)) {
            echo "<table>";
            echo "<thead>";
            echo "<tr><th>Country Name</th><th>Continent</th><th>Independence 
Year</th><th>Head of State</th></tr>";
            echo "</thead><tbody>";
            foreach ($r as $row) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['continent']) . "</td>";
                echo "<td>" . htmlspecialchars($row['independence_year']) . "</td>";
                echo "<td>" . htmlspecialchars($row['head_of_state']) . "</td>";
                echo "</tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<p>No countries found.</p>";
        }
    }

} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
    exit;
}
?>

