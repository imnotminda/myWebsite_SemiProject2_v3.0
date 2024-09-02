<?php
include 'connect.php';

if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $checkEmail = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($checkEmail);

    if ($result->num_rows > 0) {
        echo json_encode(false); // Email exists
    } else {
        echo json_encode(true); // Email does not exist
    }
}
?>
