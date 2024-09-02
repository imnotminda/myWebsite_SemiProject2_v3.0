<?php 

include 'connect.php';

header('Content-Type: application/json');

if(isset($_POST['signUp'])){
    $firstName=$_POST['fName'];
    $lastName=$_POST['lName'];
    $email=$_POST['email'];
    $password=$_POST['password'];
    $password=md5($password);

    $insertQuery = "INSERT INTO users (firstName, lastName, email, password)
    VALUES ('$firstName', '$lastName', '$email', '$password')";

if($conn->query($insertQuery) === TRUE){
header("Location: index.php");
} else {
echo "Error: " . $conn->error;
exit();
}
} 



if(isset($_POST['signIn'])){
    $email = $_POST['email'];
    $password = md5($_POST['password']);
   
    $sql = "SELECT * FROM users WHERE email='$email' and password='$password'";
    $result = $conn->query($sql);
    
   if($result->num_rows>0){
    session_start();
    $row=$result->fetch_assoc();
    $_SESSION['email']=$row['email'];
    header("Location: board.php");
    exit();
   }
   else{
    echo "Not Found, Incorrect Email or Password";
   }

}
?>