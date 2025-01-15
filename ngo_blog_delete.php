<?php
include './database/config.php';

$did = $_GET['blog_id'];

  $query = "DELETE FROM blog WHERE blog_id='$did'";
  $query_run = mysqli_query($conn, $query);

  if ($query_run) {   

    echo "<script> 
    alert('Blog has been Deleted.');
    window.location.href='ngo_blog.php';
    </script>";
    

  }else{
    echo "<script>alert('Cannot Delete Donner');
      window.location.href='ngo_blog.php';
      </script>";
  }
?>