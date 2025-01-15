<?php
include './database/config.php';

$did = $_GET['cause_id'];

// Start a transaction
mysqli_begin_transaction($conn);

try {
    // First, delete from the dependent table
    $delete_img_query = "DELETE FROM cause_img WHERE cause_id='$did'";
    $delete_img_query_run = mysqli_query($conn, $delete_img_query);

    // Check if the deletion from cause_img was successful
    if (!$delete_img_query_run) {
        throw new Exception("Failed to delete from cause_img table");
    }

    // Now delete from the causes table
    $delete_cause_query = "DELETE FROM causes WHERE cause_id='$did'";
    $delete_cause_query_run = mysqli_query($conn, $delete_cause_query);

    // Check if the deletion from causes was successful
    if (!$delete_cause_query_run) {
        throw new Exception("Failed to delete from causes table");
    }

    // If both deletions were successful, commit the transaction
    mysqli_commit($conn);

    echo "<script> 
    alert('Donner has been Deleted.');
    window.location.href='donner_causes.php';
    </script>";
} catch (Exception $e) {
    // If there was an error, rollback the transaction
    mysqli_rollback($conn);

    echo "<script>
    alert('Cannot Delete Donner. Error: " . $e->getMessage() . "');
    window.location.href='donner_causes.php';
    </script>";
}

// Close the connection
mysqli_close($conn);
?>
