<?php
include('../common/config.php');

$response = [];

// Check required parameters
if (!empty($_POST['fullName']) && !empty($_POST['email']) && !empty($_POST['description'])) {
    // Sanitize inputs
    $userId = isset($_SESSION['id']) ? $_SESSION['id'] : null;
    $fullName = $connection->real_escape_string($_POST['fullName']);
    $email = $connection->real_escape_string($_POST['email']);
    $countryCode = $connection->real_escape_string($_POST['countryCode']);
    $phone = $countryCode . $connection->real_escape_string($_POST['phone']);
    $countryId = $connection->real_escape_string($_POST['countryId']);
    $purpose = $connection->real_escape_string($_POST['purpose']);
    $description = $connection->real_escape_string($_POST['description']);

    if ($userId) {
        // Insert data into contacts table
        $sql = "INSERT INTO contacts (userId, name, email, phone, country, purpose, description) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $connection->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("issssss", $userId, $fullName, $email, $phone, $countryId, $purpose, $description);

            if ($stmt->execute()) {
                $response['success'] = "1";
                $response["message"] = "Thanks for contacting us. We will get back to you very soon.";
            } else {
                $response['success'] = "0";
                $response["message"] = "Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $response['success'] = "0";
            $response["message"] = "Error: " . $connection->error;
        }
    } else {
        $response['success'] = "0";
        $response["message"] = "User session not found. Please log in.";
    }
} else {
    $response['success'] = "0";
    $response["message"] = "Parameter(s) missing!";
}

// Output response as JSON
echo json_encode($response);
?>
