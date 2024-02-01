<?php
include 'dbconn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get data from the POST request
    $username = $_POST['email']; // Change this line to use 'email'
    $password = $_POST['password'];
    // Perform login check in the 'users' table
    $sql = "SELECT * FROM users WHERE email = '$username'";
    $result = $conn->query($sql);
//     
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // echo json_encode($row['password']);
        // exit();
        // Verify the entered password against the hashed password in the database
        if ($password == $row['password']) {
        // if (password_verify($password, $row['password'])) {
            // Password is correct, set session or perform other actions
            session_start();
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['email'];
            $response = ['success' => true, 'message' => 'Logged in'];
            // Redirect to the home page or any other authorized page
           // header("Location: index.html");
            //exit();
        } else {
            // Incorrect password
            $response = ['success' => false, 'message' => 'Incorrect password. Please try again.'];
        }
    } else {
        // User not found
        $response = ['success' => false, 'message' => 'User not found. Please check your username.'];
    }

    echo json_encode($response);
}
?>
