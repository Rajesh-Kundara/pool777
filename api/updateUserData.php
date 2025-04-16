<?php
include('../common/config.php');
$response = array();

if (!empty($_POST['tab'])) {
    $tab = $_POST['tab'];
    $userId = !empty($_POST['userId']) ? $_POST['userId'] : (isset($_SESSION['id']) ? $_SESSION['id'] : null);

    if (!$userId) {
        $response['success'] = "0";
        $response['message'] = "User ID is missing.";
        echo json_encode($response);
        exit;
    }

    // Initialize variables for prepared statements
    $sql = "";
    $params = [];
    $types = "";

    switch ($tab) {
        case "personal":
            $sql = "UPDATE users SET 
                    f_name = ?, m_name = ?, l_name = ?, company = ?, email = ?, 
                    countryCode = ?, phone = ?, countryCode_gsm = ?, phone_gsm = ?, 
                    zipcode = ?, countryId = ?, stateId = ?, street = ? WHERE id = ?";
            $params = [
                $_POST['firstName'], $_POST['middleName'], $_POST['lastName'], $_POST['company'], $_POST['email'],
                $_POST['countryCode'], $_POST['phone'], $_POST['countryCode_gsm'], $_POST['phone_gsm'],
                $_POST['zipcode'], $_POST['countryId'], $_POST['stateId'], $_POST['street'], $userId
            ];
            $types = "sssssssssssisi";
            break;

        case "account":
            $sql = "UPDATE users SET 
                    prefCurrency = ?, bankCountry = ?, bankName = ?, branch = ?, 
                    accountNo = ?, accountName = ?, iban = ?, bankBeneficier = ? WHERE id = ?";
            $params = [
                $_POST['prefCurrency'], $_POST['bankCountry'], $_POST['bankName'], $_POST['branch'],
                $_POST['accountNo'], $_POST['accountName'], $_POST['iban'], $_POST['bankBeneficier'], $userId
            ];
            $types = "ssssssssi";
            break;

        case "password":
            $sql = "UPDATE users SET password = ? WHERE id = ? AND password = ?";
            $params = [$_POST['newPassword'], $userId, $_POST['oldPassword']];
            $types = "sis";
            break;

        default:
            $response['success'] = "0";
            $response['message'] = "Invalid tab specified.";
            echo json_encode($response);
            exit;
    }

    // Execute the prepared statement
    $stmt = $connection->prepare($sql);
    if ($stmt) {
        $stmt->bind_param($types, ...$params);
        if ($stmt->execute()) {
            if ($tab == "password" && $stmt->affected_rows == 0) {
                $response['success'] = "0";
                $response['message'] = "Wrong old password!";
            } else {
                $response['success'] = "1";
                $response['message'] = "Details successfully updated.";
            }
        } else {
            $response['success'] = "0";
            $response['message'] = "Error executing query: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $response['success'] = "0";
        $response['message'] = "Error preparing query: " . $connection->error;
    }
} else {
    $response['success'] = "0";
    $response['message'] = "Parameter(s) missing!";
}

echo json_encode($response);
?>
