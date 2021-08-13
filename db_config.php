<?php

try {
    $conn = new PDO('mysql:host=localhost; dbname=empmaster;charset=utf8', 'root', ''); 
        $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION); 
    // echo "Connection successful";
    // echo "<br>";
} catch (PDOException $e) {
    echo "<p>Unable to Connect (database): " . $e->getMessage() . "</p>";
}
