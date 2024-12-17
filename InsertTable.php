<?php
    $servername = "140.82.0.181";
    $username = "PHP";
    $password = "PHPUser";
    $dbname = "ScoutingApp";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        echo json_encode(["message" => "Database connection failed: " . $conn->connect_error]);
        exit;
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $inputData = file_get_contents("php://input");
        $data = json_decode($inputData, true);
    
        if (!isset($data['ScouterName']) || !isset($data['TeamNumber'])) {
            echo json_encode(["status" => "error", "message" => "Scouter Name and Team Number are required."]);
            exit();
        }
    
        $scouterName = $data['ScouterName'] ?? '';
        $teamNumber = (int)($data['TeamNumber'] ?? 0);
        $drivetrain = $data['DriveTrain'] ?? '';
        $speed = $data['Speed'] ?? '';
        $durability = $data['Durability'] ?? '';
        $specialfeatures = $data['SpecialFeatures'] ?? '';
        $matchperformance = $data['MatchPerformance'] ?? '';
        $autonomouspoints = (int)($data['AutonomousNum'] ?? 0);
        $autonomousperformance = $data['Autonomous'] ?? '';
        $teleoppoints = (int)($data['TeleopNum'] ?? 0);
        $teleopperformance = $data['Teleop'] ?? '';
        $endgamepoints = (int)($data['EndgameNum'] ?? 0);
        $endgameperformance = $data['Endgame'] ?? '';
    
        $stmt = $conn->prepare("
            INSERT INTO Users 
            (scouterName, teamNumber, drivetrain, speed, durability, specialFeatures, matchPerformance, autonomousPoints, autonomousPerformance, teleopPoints, teleopPerformance, endgamePoints, endgamePerformance) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
    
        $stmt->bind_param(
            "sisssssisisis", 
            $scouterName, 
            $teamNumber, 
            $drivetrain, 
            $speed, 
            $durability, 
            $specialfeatures, 
            $matchperformance, 
            $autonomouspoints, 
            $autonomousperformance, 
            $teleoppoints, 
            $teleopperformance, 
            $endgamepoints, 
            $endgameperformance
        );    
        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Data inserted successfully"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Execute failed: " . $stmt->error]);
        }
    }
    $stmt->close();
    $conn->close();
?>

