<?php
// login.php

// Include the database connection file
include 'dbconn.php';

// Check if the form is submitted
if (isset($_POST['login'])) {
    // Get user input
    $email = $_POST['email'];  // Change from $username to $email
    $password = $_POST['password'];

    // Use prepared statement to prevent SQL injection
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if a matching record was found
        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();

            // Verify the hashed password
            if (password_verify($password, $user['password'])) {
                // Successful login
                $response = ['success' => true, 'message' => 'Login successful'];
            } else {
                // Invalid password
                $response = ['success' => false, 'message' => 'Invalid password'];
            }
        } else {
            // Invalid username or no matching record
            $response = ['success' => false, 'message' => 'Invalid username'];
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        // Handle statement preparation error
        $response = ['success' => false, 'message' => 'Statement preparation error'];
    }

    // Close the result set
    $result->close();

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
