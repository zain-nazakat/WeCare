<?php
include './database/config.php';

$did = $_GET['id'];

  $query = "DELETE FROM donners WHERE donner_id='$did'";
  $query_run = mysqli_query($conn, $query);

  if ($query_run) {   

    echo "<script> 
    alert('Donner has been Deleted.');
    window.location.href='admin_donners.php';
    </script>";
    

  }else{
    echo "<script>alert('Cannot Delete Donner');
      window.location.href='admin_donners.php';
      </script>";
  }
?>