<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: index.php"); // Redirect to login page if not logged in
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="forum_style.css"> <!-- Updated to match board.php -->
    <title>Write</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }
        body {
            background-color: #c9d6ff;
            background: linear-gradient(to right, #e2e2e2, #c9d6ff);
        }
        .container {
            background: #fff;
            width: 800px;
            padding: 1.5rem;
            margin: 50px auto;
            border-radius: 10px;
            box-shadow: 0 20px 35px rgba(0, 0, 1, 0.9);
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        .header {
            background-color: rgb(218, 231, 255);
            text-align: center;
            padding: 10px;
            font-weight: bold;
        }
        input[type="text"], textarea {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid lightgray;
            border-radius: 5px;
            font-size: 14px;
        }
        textarea {
            height: 200px; /* Adjusted to match the board */
            resize: vertical;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            font-size: 15px;
            border: 0;
            outline: 1.5px rgb(68, 136, 244) solid;
            border-radius: 5px;
            background-color: rgb(164, 199, 255);
            color: #fff;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: rgb(68, 136, 244);
        }
    </style>
</head>
<body>
    <div class="container">
        <form action="create_post.php" method="post">
            <table>
                <tr><td><h2>글쓰기</h2></td></tr>
                <tr><td class="header">Title</td></tr>
                <tr><td><input type="text" placeholder="제목을 입력하세요" name="title" required></td></tr>
                <tr><td class="header">Content</td></tr>
                <tr><td><textarea placeholder="내용을 입력하세요" name="detail" rows="10" required></textarea></td></tr>
                <tr><td><input type="submit" value="등록"></td></tr>
            </table>
        </form>
    </div>
</body>
</html>
