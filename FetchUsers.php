<?php
    header('Content-Type: application/json'); 
    header('Cache-Control: no-cache, must-revalidate'); 
    $servername = "140.82.0.181";
    $username = "PHP";
    $password = "PHPUser";
    $dbname = "ScoutingApp";
    $conn = new mysqli($servername, $username, $password, $dbname);

    $stmt = $conn->prepare('SELECT * FROM Users');
    $stmt->execute();
    
    $result = $stmt->get_result();

    $rows = [];
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;  
    }
    
    echo json_encode([
        'success' => true,
        'rows' => $rows, 
    ]); 

    $stmt->close();
    $conn->close();
    exit;
?>
