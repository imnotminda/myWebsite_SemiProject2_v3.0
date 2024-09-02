<?php
include 'connect.php';

header('Content-Type: application/json');

if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = md5($_POST['password']); // Hash the password

    // Prepare the SQL query to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => '이메일 또는 비밀번호가 일치하지 않습니다']);
    }

    $stmt->close();
    exit();
}
?>
