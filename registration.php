<?php
include 'dbconn.php';

// Get data from the POST request
$fullname = $_POST['fullname'];
$password = $_POST['password'];
$email = $_POST['email'];
$mobile = $_POST['mobile'];


//hashing
//$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Perform the insertion into the 'users' table
$sql = "INSERT INTO users (fullname, email, phone,password) VALUES ('$fullname','$email', '$mobile','$password')";
// $sql = "INSERT INTO users (fullname, email) VALUES ('dilu', 'dilu@mail.com')";

if ($conn->query($sql) === TRUE) {
    $response = ['success' => true, 'message' => 'User registered successfully'];
    echo json_encode($response);
} else {
    $response = ['success' => false, 'message' => 'Error: ' . $sql . '<br>' . $conn->error];
    echo json_encode($response);
}
?>