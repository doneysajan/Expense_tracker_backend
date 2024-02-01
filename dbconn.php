<?php
    $servername="localhost";
    $usernames="root";
    $passwords="";
    $database="expensetracker";

    $conn=new mysqli($servername,$usernames,$passwords,$database);

    if($conn->connect_error)
    {
        die("Connection failed: " . $conn->connect_error);
    }
    // echo "Connected successfully";

?>