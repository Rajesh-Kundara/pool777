<?php
include('../common/config.php');

$response = [];

if (!empty($_POST['winner']) && !empty($_POST['idForUpdate'])) {
    // Retrieve and sanitize input
    $idForUpdate = intval($_POST['idForUpdate']);
    $winner = $_POST['winner'];
    $homeScore = isset($_POST['homeScore']) ? intval($_POST['homeScore']) : 0;
    $awayScore = isset($_POST['awayScore']) ? intval($_POST['awayScore']) : 0;

    // Initialize variables
    $isResultDeclared = 0;
    $isHomeWinner = 0;
    $isAwayWinner = 0;
    $winnerInStack = -1;

    // Determine the results based on the winner
    switch ($winner) {
        case "H": // Home team wins
            $isResultDeclared = 1;
            $isHomeWinner = 1;
            $isAwayWinner = 0;
            $winnerInStack = 1; // Home
            break;
        case "A": // Away team wins
            $isResultDeclared = 1;
            $isHomeWinner = 0;
            $isAwayWinner = 1;
            $winnerInStack = 2; // Away
            break;
        case "D": // Draw
            $isResultDeclared = 1;
            if ($homeScore > 0 && $awayScore > 0) {
                $isHomeWinner = 1;
                $isAwayWinner = 1;
            }
            $winnerInStack = 0; // Draw
            break;
        case "N": // Not declared
        default:
            $isResultDeclared = 0;
            $isHomeWinner = 0;
            $isAwayWinner = 0;
            $homeScore = 0;
            $awayScore = 0;
            $winnerInStack = -1; // Not declared
            break;
    }

    // Update the matches table
    $updateMatchesSql = "
        UPDATE matches 
        SET 
            isResultDeclared = ?, 
            isHomeWinner = ?, 
            homeScore = ?, 
            awayScore = ?, 
            isAwayWinner = ? 
        WHERE id = ?
    ";
    $stmt = $connection->prepare($updateMatchesSql);
    $stmt->bind_param(
        "iiiisi",
        $isResultDeclared,
        $isHomeWinner,
        $homeScore,
        $awayScore,
        $isAwayWinner,
        $idForUpdate
    );

    if ($stmt->execute()) {
        // Update the stackdetail table
        $updateStackDetailSql = "
            UPDATE stackdetail 
            SET winner = ? 
            WHERE matchId = ?
        ";
        $stmt = $connection->prepare($updateStackDetailSql);
        $stmt->bind_param("ii", $winnerInStack, $idForUpdate);

        if ($stmt->execute()) {
            $response['success'] = "1";
            $response['message'] = "Data saved successfully.";
        } else {
            $response['success'] = "0";
            $response['message'] = "Error updating stack detail: " . $stmt->error;
        }
    } else {
        $response['success'] = "0";
        $response['message'] = "Error updating match: " . $stmt->error;
    }

    $stmt->close();
} else {
    $response['success'] = "0";
    $response['message'] = "Parameter(s) missing!";
}

echo json_encode($response);
?>
