<?php
include('../common/config.php');

$response = [];

// Check required parameters
if (!empty($_POST['userName']) && !empty($_POST['password']) && !empty($_POST['countryCode']) && !empty($_POST['phone'])) {
    // Sanitize input
    $userName = $connection->real_escape_string($_POST['userName']);
    $password = $connection->real_escape_string($_POST['password']);
    $countryCode = $connection->real_escape_string($_POST['countryCode']);
    $phone = $connection->real_escape_string($_POST['phone']);

    // Check if username already exists
    $sql = "SELECT * FROM users WHERE userName = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s", $userName);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 0) {
        // Username not found, proceed with insertion
        $insertSql = "INSERT INTO users (userName, password, countryCode, phone) VALUES (?, ?, ?, ?)";
        $insertStmt = $connection->prepare($insertSql);
        $insertStmt->bind_param("ssss", $userName, $password, $countryCode, $phone);

        if ($insertStmt->execute()) {
            $response['success'] = "1";
            $response["message"] = "Registered successfully!";
        } else {
            $response['success'] = "0";
            $response["message"] = "Error: " . $connection->error;
        }
        $insertStmt->close();
    } else {
        // Username already exists
        $response['success'] = "0";
        $response["message"] = "Username is taken! Please try a different username.";
    }
    $stmt->close();
} else {
    // Missing parameters
    $response['success'] = "0";
    $response["message"] = "Parameter(s) missing!";
}

// Output response as JSON
echo json_encode($response);
?>
