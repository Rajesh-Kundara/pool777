<?php
include('../config.php');
$response = array();

if (!empty($_POST['selectedBankerId']) && !empty($_POST['selectedNumbers']) && !empty($_POST['stackAmount']) ) {
    // Initialize variables
    $userId = !empty($_POST['userId']) ? $_POST['userId'] : (isset($_SESSION['id']) ? $_SESSION['id'] : null);
    $selectedBankerId = $_POST['selectedBankerId'];
    $selectedNumbers = $_POST['selectedNumbers'];
    $stackAmount = $_POST['stackAmount'];
    

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

    if ($stackAmount <= $balance) {
        // Insert stack record
        $stmt = $connection->prepare(
            "INSERT INTO lotto (userId, bankerId, numbers, stackAmount)
            VALUES (?, ?, ?, ?)"
        );
        $stmt->bind_param("iisi", $userId, $selectedBankerId, $selectedNumbers, $stackAmount);

        if ($stmt->execute()) {
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
