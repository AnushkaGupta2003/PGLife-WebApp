<?php
    require("../includes/database_connect.php");

$full_name = $_POST['full_name'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$password = $_POST['password'];  // sha1(string) where string is input
$password = sha1($password);    // in $password variable
$college_name = $_POST['college_name'];
$gender = $_POST['gender'];

$sql_1="SELECT * FROM users WHERE email='$email'";
$result_1=mysqli_query($conn, $sql_1);
if(!$result_1)
{
    $response = array("success" => false, "message" => "Something went wrong!");
    echo json_encode($response);
    return;
}
 $count=mysqli_num_rows($result_1);
 if($count!=0){
    $response = array("success" => false, "message" => "This email id is already registered with us!");
    echo json_encode($response);
    return;
 }
  $sql_2="INSERT INTO users (email, password, full_name, phone, gender, college_name) VALUES ('$email', '$password', '$full_name', '$phone', '$gender', '$college_name')";
  $result_2=mysqli_query($conn, $sql_2);
  if(!$result_2)
  {
    $response = array("success" => false, "message" => "Something went wrong!");
    echo json_encode($response);
    return;
  }
  $response = array("success" => true, "message" => "Your account has been created successfully!");
  echo json_encode($response);
mysqli_close($conn);
?>

