<?php
session_start();
include_once("../../../includes/config.php");
if (!isset($_SESSION['admin_id']) || empty($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit; 
}

$AdminID = $_SESSION['admin_id'] ?? '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle form data
    $equipmentName = $_POST['equipment_name_modal'];
    $description = $_POST['description_modal'];
    $equipmentId = $_POST['equipment_id_modal'];
    

    // Validate form data
    if (empty($equipmentName) || empty($description) || empty($equipmentId)) {
        // Handle error 
        $response = array('success' => false, 'message' => 'All fields are required');
        echo json_encode($response);
        exit;
    }

    // Perform database update
    try {
        $dbh = new PDO("pgsql:" . $host);
        
        // Prepare the update statement
        $updateCategoryStmt = $dbh->prepare("UPDATE repo_equipment_category SET description = :description, equipment_name = :equipment_name WHERE equipment_id = :equipment_id");
        
        // Bind parameters
        $updateCategoryStmt->bindParam(':description', $description);
        $updateCategoryStmt->bindParam(':equipment_name', $equipmentName);
        $updateCategoryStmt->bindParam(':equipment_id', $equipmentId);
        
        // Execute the update statement
        $updateSuccess = $updateCategoryStmt->execute();
        
        if ($updateSuccess) {
            $log_timestamp = date("Y-m-d");
            $log_action = "Equiptment Category Info Updated"; // Your desired log action

            $insertLogQuery = "INSERT INTO repo_admin_logs (repo_admin_id, repo_admin_uuid, log_timestamp, log_action) VALUES ($1, $2, $3, $4)";
            $result_insert_log = pg_query_params($db_connection, $insertLogQuery, array($AdminID, $AdminID, $log_timestamp, $log_action));
            
            if ($result_insert_log) {
                // Log inserted successfully
                echo "Log inserted successfully!";
            } else {
                // Error inserting log
                $error_message = pg_last_error($db_connection);
                echo "Error inserting log: " . $error_message;
            }
            
            $response = array('success' => true, 'message' => 'Equipment updated successfully');
            echo json_encode($response);
        } else {
            // Send error response back to client
            $response = array('success' => false, 'message' => 'Failed to update equipment');
            echo json_encode($response);
        }
    } catch (PDOException $e) {
        // Send error response back to client if database connection or query fails
        $response = array('success' => false, 'message' => 'Error updating equipment: ' . $e->getMessage());
        echo json_encode($response);
    }
} else {
    // If the request method is not POST, return an error response
    $response = array('success' => false, 'message' => 'Invalid request method');
    echo json_encode($response);
}
?>