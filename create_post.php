<?php
session_start();
include 'connect.php'; // Include your database connection file

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: index.php"); // Redirect to login page if not logged in
    exit();
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the form fields are set
    if (isset($_POST['title']) && isset($_POST['detail'])) {
        $title = $_POST['title'];
        $detail = $_POST['detail'];
        $email = $_SESSION['email'];

        // Get the first name of the user from the session
        $userQuery = $conn->prepare("SELECT firstName FROM users WHERE email = ?");
        $userQuery->bind_param("s", $email);
        $userQuery->execute();
        $userResult = $userQuery->get_result();
        $user = $userResult->fetch_assoc();
        $firstName = $user['firstName'];

        // Insert the new post into the board
        $insertQuery = $conn->prepare("INSERT INTO board (subject, content, firstName, logdate) VALUES (?, ?, ?, NOW())");
        $insertQuery->bind_param("sss", $title, $detail, $firstName);

        if ($insertQuery->execute()) {
            header("Location: board.php"); // Redirect to board.php after successful insertion
            exit();
        } else {
            echo "Error: " . $insertQuery->error;
        }

        // Close the prepared statements
        $insertQuery->close();
        $userQuery->close();
    }
} else {
    header("Location: write.php"); // Redirect to the write page if not a POST request
    exit();
}
?>
