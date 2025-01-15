<?php
include './database/config.php';

$did = $_GET['id'];

  $query = "UPDATE ngo SET `verified` = '1' WHERE ngo_id='$did'";
  $query_run = mysqli_query($conn, $query);

  if ($query_run) {   

    echo "<script> 
    alert('Verification Successfull.');
    window.location.href='admin_ngos.php';
    </script>";
    

  }else{
    echo "<script>alert('Cannot Confirm verification Request');
      window.location.href='admin_ngos.php';
      </script>";
  }
?>