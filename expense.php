<?php
include 'dbconn.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $uid = $_SESSION['user_id'];

    $amount = $_POST['amount'];
    $date = $_POST['date'];
    $paymentMethod = $_POST['payment'];
    $category = $_POST['maincategory'];
    $otherCategory = $_POST['othersTextBoxContainer'];
    $merchantName = $_POST['merchantname'];
    $notes = $_POST['notes'];

    if ($category == 'Others' && !empty($otherCategory)) {
        $insertCategoryQuery = "INSERT INTO category (uid, name) VALUES ('$uid', '$otherCategory')";
        if ($conn->query($insertCategoryQuery) === TRUE) {
            $cid = $conn->insert_id;

            $sql = "INSERT INTO expense (uid, cid, amount, date, payment,maincategory, merchantname, notes) 
                    VALUES ('$uid', '$cid', '$amount', '$date', '$paymentMethod','$category', '$merchantName', '$notes')";
            if ($conn->query($sql) === TRUE) {
                $response = ['success' => true, 'message' => 'Expense added successfully'];
                echo json_encode($response);
            } else {
                $response = ['success' => false, 'message' => 'Error: ' . $sql . '<br>' . $conn->error];
                echo json_encode($response);
            }
        } else {
            $response = ['success' => false, 'message' => 'Error inserting category: ' . $conn->error];
            echo json_encode($response);
        }

        
    } else {
        $sql = "INSERT INTO expense (uid, amount, date, payment, maincategory, merchantname, notes) 
                VALUES ('$uid', '$amount', '$date', '$paymentMethod', '$category', '$merchantName', '$notes')";

        if ($conn->query($sql) === TRUE) {
            $response = ['success' => true, 'message' => 'Expense added successfully'];
            echo json_encode($response);
        } else {
            $response = ['success' => false, 'message' => 'Error: ' . $sql . '<br>' . $conn->error];
            echo json_encode($response);
        }
    }
} else {
    $response = ['success' => false, 'message' => 'User not logged in'];
    echo json_encode($response);
}
?>

