<?php
include('../config.php');

// Start the session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$response = ['success' => 0, 'message' => 'An error occurred'];

if (!empty($_POST['userName']) && !empty($_POST['password'])) {
    $userName = trim($_POST['userName']);
    $password = trim($_POST['password']);

    // Use a prepared statement to prevent SQL injection
    $sql = "SELECT * FROM users WHERE (userName = ? OR phone = ?)";
    $stmt = $connection->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("ss", $userName, $userName);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Verify the password (assuming the password is hashed in the database)
            if ($password ==$row['password']) {
                $_SESSION['fullname'] = trim($row['f_name'] . " " . $row['m_name'] . " " . $row['l_name']);
                $_SESSION['id'] = (string)$row['id'];
                $_SESSION['type'] = $row['role'];
                $_SESSION['username'] = $row['userName'];

                // Set cookies
                setcookie('fullname', $_SESSION['fullname'], time() + (60 * 60 * 24 * 365));
                setcookie('id', $_SESSION['id'], time() + (60 * 60 * 24 * 365));
                setcookie('type', $_SESSION['type'], time() + (60 * 60 * 24 * 365));

                // Success response
                $response['success'] = 1;
                $response['fullname'] = $_SESSION['fullname'];
                $response['id'] = $_SESSION['id'];
                $response['type'] = $_SESSION['type'];
                $response['username'] = $_SESSION['username'];
                $response['message'] = "Welcome " . $_SESSION['fullname'];
                // $date = date('Y-m-d H:i:s');
			
                // $sql = "update users set lastLogin = '".$date."' where id = '".$row['id']."'";
                // $result = $connection->query($sql);
            } else {
                $response['message'] = "Invalid username or password.";
            }
        } else {
            $response['message'] = "User not found or invalid credentials.";
        }

        $stmt->close();
    } else {
        $response['message'] = "Database error: Unable to prepare statement.";
    }
} else {
    $response['message'] = "Parameters missing!";
}

echo json_encode($response);
?>
