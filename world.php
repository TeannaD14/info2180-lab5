<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

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

// Output HTML
?>
<ul>
<?php foreach ($r as $row): ?>
  <li><?= htmlspecialchars($row['name']) . ' is ruled by ' . 
htmlspecialchars($row['head_of_state']); ?></li>
<?php endforeach; ?>
</ul>
