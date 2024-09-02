<?php 
session_start(); 
include 'connect.php'; // Ensure this file includes the database connection

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: index.php"); // Redirect to login page if not logged in
    exit();
}

// Retrieve the logged-in user's email
$email = $_SESSION['email'];

// Prepare and execute the query to get the user's first name
$userQuery = $conn->prepare("SELECT firstName FROM users WHERE email = ?");
if (!$userQuery) {
    die("Prepare failed: " . $conn->error);
}
$userQuery->bind_param("s", $email);
$userQuery->execute();
$userResult = $userQuery->get_result();
$user = $userResult->fetch_assoc();
$firstName = htmlspecialchars($user['firstName']);

// Prepare and execute the query to get board data
$boardQuery = $conn->prepare("
    SELECT seq, subject, firstName, logdate 
    FROM board
    ORDER BY logdate DESC
");
if (!$boardQuery) {
    die("Prepare failed: " . $conn->error);
}
$boardQuery->execute();
$boardResult = $boardQuery->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"> 
    <link rel="stylesheet" href="forum_style.css">
    <title>Forum</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .container {
            position: relative;
        }
        .email-display {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 1em;
            color: #333;
        }
    </style>
</head>
<body>
<div class="container">
        <div class="email-display">
            <?php echo $firstName; ?>
        </div>
        <table class="table">
            <tr><td colspan="4"><h2>게시판</h2></td></tr>
            <tr class="header">
                <td class="num">번호</td>
                <td class="title">제목</td>
                <td>작성자</td>
                <td>작성날짜</td>
            </tr>
            <?php while ($row = $boardResult->fetch_assoc()): ?>
                <tr class="body">
                    <td><?php echo htmlspecialchars($row['seq']); ?></td>
                    <td class="title">
                        <a href="view_post.php?seq=<?php echo htmlspecialchars($row['seq']); ?>">
                            <?php echo htmlspecialchars($row['subject']); ?>
                        </a>
                    </td>
                    <td><?php echo htmlspecialchars($row['firstName']); ?></td>
                    <td><?php echo htmlspecialchars($row['logdate']); ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
        <br>
        <table>
            <tr>
                <td><button onclick="location.href='write.php'">글쓰기</button></td>
            </tr>
        </table>
    </div>
</body>
</html>

<?php
// Close the prepared statements and connection
$boardQuery->close();
$userQuery->close();
$conn->close();
?>
