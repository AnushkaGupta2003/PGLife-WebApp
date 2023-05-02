<?php
session_start();
 require ("../includes/database_connect.php");

$email = $_POST['email'];
$password = $_POST['password'];  // sha1(string) where string is input
$password = sha1($password);    // in $password variable

$sql="SELECT * FROM users WHERE email='$email' and password='$password' ";
$result=mysqli_query($conn, $sql);
if(!$result)
{
    $response=array("success" => false, "message" => "Something went wrong!");
    echo json_encode($response);
    return;
}
 $row=mysqli_fetch_assoc($result );
 if(!$row){
    $response=array("success" => false, "message" => "You have entered incorrect email or password !");
    echo json_encode($response);
    return;
 }
 $_SESSION["user_id"]=$row['id'];
 $_SESSION["full_name"]=$row['full_name'];
 $_SESSION['email'] = $row['email'];

$response = array("success" => true, "message" => "Login successful!");
echo json_encode($response);
mysqli_close($conn);

