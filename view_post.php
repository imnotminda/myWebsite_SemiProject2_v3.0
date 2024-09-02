<?php
session_start();
include 'connect.php'; // Include your database connection file

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: index.php"); // Redirect to login page if not logged in
    exit();
}

// Check if 'seq' parameter is provided in the URL
if (!isset($_GET['seq']) || !is_numeric($_GET['seq'])) {
    echo "Invalid request.";
    exit();
}

// Retrieve the 'seq' parameter from the URL
$seq = intval($_GET['seq']);

// Prepare and execute the query to get the post details
$postQuery = $conn->prepare("SELECT seq, subject, content, firstName, logdate FROM board WHERE seq = ?");
if (!$postQuery) {
    die("Prepare failed: " . $conn->error);
}
$postQuery->bind_param("i", $seq);
$postQuery->execute();
$postResult = $postQuery->get_result();

if ($postResult->num_rows === 0) {
    echo "Post not found.";
    exit();
}

// Fetch the post details
$post = $postResult->fetch_assoc();

// Retrieve logged-in user's email
$email = $_SESSION['email'];

// Get the first name of the user
$userQuery = $conn->prepare("SELECT firstName FROM users WHERE email = ?");
if (!$userQuery) {
    die("Prepare failed: " . $conn->error);
}
$userQuery->bind_param("s", $email);
$userQuery->execute();
$userResult = $userQuery->get_result();
$user = $userResult->fetch_assoc();
$firstName = htmlspecialchars($user['firstName']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"> 
    <link rel="stylesheet" href="forum_style.css">
    <title>View Post</title>
    <style>
        .container {
            max-width: 800px;
            margin: auto;
            padding: 1.5rem;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 20px 35px rgba(0, 0, 0, 0.1);
        }
        .post-title {
            font-size: 2em;
            margin-bottom: 0.5em;
        }
        .post-meta {
            font-size: 1em;
            color: #555;
            margin-bottom: 1em;
        }
        .post-content {
            font-size: 1.2em;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="post-title"><?php echo htmlspecialchars($post['subject']); ?></h1>
        <div class="post-meta">
            <p>작성자: <?php echo htmlspecialchars($post['firstName']); ?></p>
            <p>작성날짜: <?php echo htmlspecialchars($post['logdate']); ?></p>
        </div>
        <div class="post-content">
            <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
        </div>
        <a href="board.php">Back to Board</a>
    </div>
</body>
</html>

<?php
// Close the prepared statements and connection
$postQuery->close();
$userQuery->close();
$conn->close();
?>
