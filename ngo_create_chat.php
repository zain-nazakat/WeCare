<?php
include './database/config.php';
date_default_timezone_set('Asia/Karachi');
session_start();
error_reporting(0);

if (!isset($_SESSION['ngoname'])) {
    header("Location: ngo_login.php");
}

  $ngo_id = $_GET['ngo_id'];
  $donner_id = $_GET['donner_id'];

  $date=date("d-M-y");
  $datetime=date("h:i:sa");

  $sql = "SELECT * FROM chat_room WHERE donner_id='$donner_id' AND ngo_id='$ngo_id'";
	$result = mysqli_query($conn, $sql);

  if(!$result->num_rows > 0){
    $sql = "INSERT INTO chat_room(donner_id, ngo_id, create_date) VALUES ('$donner_id', '$ngo_id', '$date')";
    $result = mysqli_query($conn, $sql);


    if($result){

      $sql2 = "SELECT * from chat_room WHERE donner_id='$donner_id' AND ngo_id='$ngo_id'";
      $result2 = mysqli_query($conn, $sql2);
      $row2=mysqli_fetch_assoc($result2);
      $room_id=$row2['room_id'];

      
      $sql3 = "INSERT INTO messages(room_id,donner_id,ngo_id,message,send_time,sender)
      VALUES ('$room_id', '$donner_id','$ngo_id','hi', '$datetime', '1')";
      $result3 = mysqli_query($conn, $sql3);
      if($result){
        header("Location: ngo_messages.php?room_id=$room_id");
      }
    }
  }else{
    $sql2 = "SELECT * from chat_room WHERE donner_id='$donner_id' AND ngo_id='$ngo_id'";
    $result2 = mysqli_query($conn, $sql2);
    $row2=mysqli_fetch_assoc($result2);
    $room_id=$row2['room_id'];
    
    header("Location: ngo_messages.php?room_id=$room_id");
  }
?>