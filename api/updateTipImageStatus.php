<?php
include('../config.php');

// Initialize default values
$response = [];
$userId = '';
$name = "Guest";
$email = '';
$mobile = '';
$address = '';

if (!empty($_POST['id']) && !empty($_POST['status'])) {
    // Sanitize input
    $id = intval($_POST['id']);
    $status = htmlspecialchars($_POST['status'], ENT_QUOTES, 'UTF-8');

    // Update query using prepared statements
    $sql = "UPDATE tips SET imageStatus = ? WHERE id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param('si', $status, $id);

    if ($stmt->execute()) {
        $response['status'] = "Success";
        $response['message'] = "Data updated successfully.";
    } else {
        $response['status'] = "Failure";
        $response['message'] = "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    $response['status'] = "Failure";
    $response['message'] = "Parameter(s) missing!";
}

// Return JSON response
echo json_encode($response);
?>
