<?php
include('../common/config.php');

$response = [];

if (!empty($_POST['homeTeam']) && !empty($_POST['awayTeam'])) {

    $isUpdate = !empty($_POST['idForUpdate']);
    $idForUpdate = $isUpdate ? intval($_POST['idForUpdate']) : null;

    // Sanitize inputs
    $week = $connection->real_escape_string($_POST['week']);
    $homeTeam = $connection->real_escape_string($_POST['homeTeam']);
    $awayTeam = $connection->real_escape_string($_POST['awayTeam']);
    $matchDate = $connection->real_escape_string($_POST['matchDate']);

    if ($isUpdate) {
        // Update query
        $sql = "UPDATE matches SET week = ?, homeTeam = ?, awayTeam = ?, matchDate = ? WHERE id = ?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("ssssi", $week, $homeTeam, $awayTeam, $matchDate, $idForUpdate);
    } else {
        // Insert query
        $sql = "INSERT INTO matches (week, homeTeam, awayTeam, matchDate) VALUES (?, ?, ?, ?)";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("ssss", $week, $homeTeam, $awayTeam, $matchDate);
    }

    if ($stmt->execute()) {
        $insertId = $isUpdate ? $idForUpdate : $connection->insert_id;
        $response['success'] = "1";
        $response['message'] = "Data saved successfully.";
    } else {
        $response['success'] = "0";
        $response['message'] = "Error: " . $stmt->error;
    }
    $stmt->close();
} else {
    $response['success'] = "0";
    $response['message'] = "Parameter(s) missing!";
}

echo json_encode($response);
?>
