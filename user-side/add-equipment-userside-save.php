<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['repo_user_id'])) {
    header('Location: login.php');
    exit;
}

// Include the configuration file
include('../includes/config.php');

// Retrieve the hospital_id using repo_user_id
$repo_user_id = $_SESSION['repo_user_id'];
$hospital_id_query = "SELECT hospital_id FROM repo_user WHERE repo_user_id = $1";
$hospital_id_result = pg_query_params($db_connection, $hospital_id_query, [$repo_user_id]);

if ($hospital_id_result && pg_num_rows($hospital_id_result) > 0) {
    $row = pg_fetch_assoc($hospital_id_result);
    $hospital_id = $row['hospital_id'];
    $_SESSION['hospital_id'] = $hospital_id; // Update the session with hospital_id
} else {
    $_SESSION['error'] = 'Failed to retrieve hospital ID.';
    header('Location: user-hospital-equipment.php');
    exit;
}

// Retrieve form data
$equipment_name = $_POST['hospital_equipment'][0];
$description = $_POST['hospital_equipment_description'];
$purchase_date = $_POST['purchase_date'];
$location = $_POST['location'];
$serial_number = $_POST['serial_number'];
$model_number = $_POST['model_number'];
$equipment_status = $_POST['equipment_status'];

// Handle the image upload
$image_url = null;
if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    $image_name = $_FILES['image']['name'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_ext = pathinfo($image_name, PATHINFO_EXTENSION);

    // Allowed file extensions
    $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];

    // Check if the file extension is allowed
    if (in_array($image_ext, $allowed_ext)) {
        // Define the upload directory
        $upload_dir = 'uploads-img/';
        // Create the upload directory if it doesn't exist
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }
        // Generate a unique file name
        $new_image_name = uniqid() . '.' . $image_ext;
        $upload_file = $upload_dir . $new_image_name;

        // Move the uploaded file to the upload directory
        if (move_uploaded_file($image_tmp_name, $upload_file)) {
            $image_url = $upload_file;
        } else {
            $_SESSION['error'] = 'Failed to upload the image.';
            header('Location: user-hospital-equipment.php');
            exit;
        }
    } else {
        $_SESSION['error'] = 'Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.';
        header('Location: user-hospital-equipment.php');
        exit;
    }
}

// Insert data into the database using pg_* functions
$query = "INSERT INTO hospital_equipment_user_side (equipment_name, description, purchase_date, location, serial_number, model_number, equipment_status, image_url, repo_user_id, hospital_id) VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9, $10)";

$params = [
    $equipment_name,
    $description,
    $purchase_date,
    $location,
    $serial_number,
    $model_number,
    $equipment_status,
    $image_url,
    $repo_user_id,
    $hospital_id
];

$result = pg_query_params($db_connection, $query, $params);

if ($result) {
    $_SESSION['success'] = 'Equipment added successfully.';
} else {
    // Debugging output
    $error = pg_last_error($db_connection);
    error_log("Database insertion failed: $error");
    $_SESSION['error'] = 'Failed to add equipment. Error: ' . $error;
}

// Debugging output
error_log("Parameters: " . print_r($params, true));

header('Location: user-hospital-equipment.php');
exit;

