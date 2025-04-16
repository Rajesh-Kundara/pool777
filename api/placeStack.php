<?php
include('../common/config.php');

$response = array();

if (!empty($_POST['week']) && !empty($_POST['couponId']) && !empty($_POST['stackAmount']) && !empty($_POST['matchesSelected'])) {
    // Initialize variables
    $userId = !empty($_POST['userId']) ? $_POST['userId'] : (isset($_SESSION['id']) ? $_SESSION['id'] : null);
    $week = $_POST['week'];
    $couponId = $_POST['couponId'];
    $couponTypeId = $_POST['couponTypeId'];
    $stackAmount = $_POST['stackAmount'];
    $matchesSelected = $_POST['matchesSelected'];
    
    $under2 = $_POST['under2'] ?? 0;
    $under3 = $_POST['under3'] ?? 0;
    $under4 = $_POST['under4'] ?? 0;
    $under5 = $_POST['under5'] ?? 0;
    $under6 = $_POST['under6'] ?? 0;
    $under7 = $_POST['under7'] ?? 0;
    $under8 = $_POST['under8'] ?? 0;
    

    if (!$userId) {
        $response['success'] = "0";
        $response['message'] = "User ID is required.";
        echo json_encode($response);
        exit;
    }

    // Fetch user balance
    $balance = 0;
    $stmt = $connection->prepare("SELECT SUM(amount) as balance FROM balance WHERE userId = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result) {
        $row = $result->fetch_assoc();
        $balance = $row['balance'];
    }
    $stmt->close();
    $response['success'] = "0";
    $response['message'] = "Exited.";
    if ($stackAmount <= $balance) {
        // Insert stack record
        $stmt = $connection->prepare(
            "INSERT INTO stacks (userId, couponId, couponTypeId, week, stackAmount, under2, under3, under4, under5, under6, under7, under8)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->bind_param("iisidddddddd", $userId, $couponId, $couponTypeId, $week, $stackAmount, $under2, $under3, $under4, $under5, $under6, $under7, $under8);

        if ($stmt->execute()) {
            $parentId = $stmt->insert_id;
            $stmt->close();

            // Insert matches into stackdetail table
            $matchesSelected = explode(',', $matchesSelected);
            foreach ($matchesSelected as $matchId) {
                $stmt = $connection->prepare("INSERT INTO stackdetail (parentId, matchId) VALUES (?, ?)");
                $stmt->bind_param("ii", $parentId, $matchId);
                $stmt->execute();
                $stmt->close();
            }
            $response['id'] = $parentId;

            // Deduct balance
            $ref = md5($couponId);
            $totalAmt = $balance - $stackAmount;
            $stmt = $connection->prepare(
                "INSERT INTO balance (userId, amount,totalAmount, type, ref, date, insertDate)
                VALUES (?, ?,?, 'S', ?, NOW(), NOW())"
            );
            $negativeAmount = -1 * $stackAmount;
            $stmt->bind_param("idds", $userId, $negativeAmount,$totalAmt, $ref);
            $stmt->execute();
            $stmt->close();

            $response['success'] = "1";
            $response['message'] = "Stacked successfully.";
            
        } else {
            $response['success'] = "0";
            $response['message'] = "Error inserting stack: " . $stmt->error;
        }
    } else {
        $response['success'] = "0";
        $response['message'] = "Stack amount ($stackAmount) exceeds your balance ($balance).";
    }
} else {
    $response['success'] = "0";
    $response['message'] = "Parameter(s) missing!";
}

// Return the response as JSON
echo json_encode($response);
?>
