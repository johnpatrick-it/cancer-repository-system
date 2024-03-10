<?php 
session_start();
include_once("../../../includes/config.php");

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    // Get repo_id from POST data
    $repoId = $_POST['repo_id'] ?? '';

    // Prepare the delete statement
    $query = "DELETE FROM repo_user WHERE repo_user_id = $1";
    $stmt = pg_prepare($db_connection, "delete_query", $query);

    if ($stmt) {
        // Execute query
        $result = pg_execute($db_connection, "delete_query", array($repoId));
        if ($result) {
            echo "success";
        } else {
            echo "error";
        }
    } else {
        echo "Error preparing query: " . pg_last_error($db_connection);
    }
}
?>
