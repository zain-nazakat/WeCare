<?php
include './database/config.php';

$did = $_GET['id'];

  $query = "DELETE FROM ngo WHERE ngo_id='$did'";
  $query_run = mysqli_query($conn, $query);

  if ($query_run) {   

    echo "<script> 
    alert('NGO has been Deleted.');
    window.location.href='admin_ngos.php';
    </script>";
    

  }else{
    echo "<script>alert('Cannot Delete NGO');
      window.location.href='admin_ngos.php';
      </script>";
  }
?>