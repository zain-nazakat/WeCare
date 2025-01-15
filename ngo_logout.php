<?php 
include_once("./database/config.php");
date_default_timezone_set('Asia/Karachi');

session_start();

$username = $_SESSION['username'];

#setting active status to 0
$sql = "UPDATE ngo SET `status`=0 WHERE username='$username'";
$result = mysqli_query($conn, $sql);

if($result){
    session_destroy();
    header("Location: index.php");
}


?>