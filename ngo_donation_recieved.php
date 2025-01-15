<?php
include './database/config.php';

$donation_id = $_GET['donation_id'];

  $query = "UPDATE donation SET status= 1 WHERE donation_id='$donation_id'";
  $query_run = mysqli_query($conn, $query);

  if ($query_run) {   

    echo "<script> 
    alert('Donation Has been Recieved.');
    window.location.href='ngo_pickup.php';
    </script>";
    

  }else{
    echo "<script>alert('Cannot Recieved Donation');
      window.location.href='ngo_pickup.php';
      </script>";
  }
?>