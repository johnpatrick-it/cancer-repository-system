<?php
session_start();
include('../includes/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $equipment_id = $_POST['equipment_id'];
    $equipment_name = $_POST['hospital_equipment'];
    $description = $_POST['hospital_equipment_description'];
    $purchase_date = $_POST['purchase_date'];
    $location = $_POST['location'];
    $serial_number = $_POST['serial_number'];
    $model_number = $_POST['model_number'];
    $equipment_status = $_POST['equipment_status'];

    // Handle file upload
    $image_path = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image_name = $_FILES['image']['name'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_path = "uploads-img/" . basename($image_name);
        if (!move_uploaded_file($image_tmp_name, $image_path)) {
            $_SESSION['error'] = 'Failed to upload image.';
            header("Location: user-hospital-equipment.php");
            exit;
        }
    }

    $query = "UPDATE hospital_equipment_user_side 
              SET equipment_name = $1, description = $2, purchase_date = $3, location = $4, serial_number = $5, model_number = $6, equipment_status = $7, image_path = $8 
              WHERE equipment_id = $9";

    $result = pg_query_params($db_connection, $query, array($equipment_name, $description, $purchase_date, $location, $serial_number, $model_number, $equipment_status, $image_path, $equipment_id));

    if ($result) {
        $_SESSION['success'] = 'Equipment updated successfully.';
    } else {
        $_SESSION['error'] = 'Failed to update equipment: ' . pg_last_error($db_connection);
    }

    header("Location: user-hospital-equipment.php");
    exit;
}
