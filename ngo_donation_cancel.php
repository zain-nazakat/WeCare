<?php
include './database/config.php';

$donation_id = $_GET['donation_id'];

  $query = "UPDATE donation SET status= 2 WHERE donation_id='$donation_id'";
  $query_run = mysqli_query($conn, $query);

  if ($query_run) {   

    echo "<script> 
    alert('Donation Has been Cancled.');
    window.location.href='ngo_pickup.php';
    </script>";
    

  }else{
    echo "<script>alert('Cannot Cancel Donation');
      window.location.href='ngo_pickup.php';
      </script>";
  }
?>