<?php
session_start();
include_once("config.php");

$AdminID = $_SESSION['admin_id'] ?? '';
<<<<<<< HEAD
=======

<<<<<<< HEAD
=======
>>>>>>> 993da59d339990ba8278087458421d2421015709

>>>>>>> 81ca0a6599ccc9ee6ed200bc17a9de80eb32573a
if (!isset($_SESSION['admin_id']) || empty($_SESSION['admin_id'])) {
    header('Location: .../login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $hospitalName = $_POST['hospital_name'] ?? '';
    $hospitalLevel = $_POST['level'] ?? '';
    $institution = $_POST['institution_level3'] ?? '';
    $region = $_POST['region'] ?? '';
    $province = $_POST['province'] ?? '';
    $city = $_POST['city'] ?? '';
    $barangay = $_POST['barangay'] ?? '';
    $street = $_POST['street'] ?? '';
    $specialty = $_POST['specialty'] ?? '';
    $hospitalEquipments = $_POST['hospital_equipment'] ?? '';
    $hospital_street = $_POST['hospital_street'] ?? '';
    $hospital_plus_code = $_POST['hospital_plus_code'] ?? '';
    $hospital_email = $_POST['hospital_email'] ?? '';
    $hospital_contact = $_POST['hospital_contact'] ?? '';
  

    // Handle image upload
   
    if (isset($_FILES['image'])) {
        $image_data = $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], '../../../uploads/'.$image_data);

    } else {
        echo "No file uploaded or the 'image'.";
    }
    

    // Start a transaction
    pg_query($db_connection, "BEGIN");

    // Prepare query to insert hospital general information
    $insertHospitalQuery = "INSERT INTO hospital_general_information (admin_id, hospital_name, hospital_level, type_of_institution, hospital_region, hospital_province, hospital_city, hospital_barangay, hospital_street, specialty, image_data) 
              VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11)";
    $result_insert_hospital = pg_query_params($db_connection, $insertHospitalQuery, array($AdminID, $hospitalName, $hospitalLevel, $institution, $region, $province, $city, $barangay, $street, $specialty, $image_data));
    if (!$result_insert_hospital) {
        echo "Error inserting hospital: " . pg_last_error($db_connection);
        pg_query($db_connection, "ROLLBACK");
        exit;
    }

    // Get the hospital_id of the newly inserted hospital
    $hospitalIdQuery = "SELECT hospital_id FROM hospital_general_information WHERE hospital_name = $1";
    $result_hospital_id = pg_query_params($db_connection, $hospitalIdQuery, array($hospitalName));
    if (!$result_hospital_id) {
        echo "Error fetching hospital ID: " . pg_last_error($db_connection);
        pg_query($db_connection, "ROLLBACK");
        exit;
    }
    
    $row = pg_fetch_assoc($result_hospital_id);
    $hospital_id = $row['hospital_id'];

    // Insert hospital equipment information
    foreach ($hospitalEquipments as $equipment) {
        $equipmentIdQuery = "SELECT equipment_id FROM repo_equipment_category WHERE equipment_name = $1";
        $result_equipment_id = pg_query_params($db_connection, $equipmentIdQuery, array($equipment));
        if (!$result_equipment_id) {
            echo "Error fetching equipment ID: " . pg_last_error($db_connection);
            pg_query($db_connection, "ROLLBACK");
            exit;
        }
        
        $row = pg_fetch_assoc($result_equipment_id);
        $equipmentId = $row['equipment_id'];

        // Insert into hospital_equipment table
        $insertEquipmentQuery = "INSERT INTO hospital_equipment (hospital_id, equipment_id) VALUES ($1, $2)";
        $result_insert_equipment = pg_query_params($db_connection, $insertEquipmentQuery, array($hospital_id, $equipmentId));
        if (!$result_insert_equipment) {
            echo "Error inserting equipment: " . pg_last_error($db_connection);
            pg_query($db_connection, "ROLLBACK");
            exit;
        }
    }

    // Insert log
    $logTimestamp = date("Y-m-d");
    $logAction = "New hospital added"; // Your desired log action

<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 81ca0a6599ccc9ee6ed200bc17a9de80eb32573a
    $insertLogQuery = "INSERT INTO repo_admin_logs (repo_admin_id, repo_admin_uuid, log_timestamp, log_action) VALUES ($1, $2, $3, $4)";
    $result_insert_log = pg_query_params($db_connection, $insertLogQuery, array($AdminID, $AdminID, $logTimestamp, $logAction));
    if (!$result_insert_log) {
        echo "Error inserting log: " . pg_last_error($db_connection);
        pg_query($db_connection, "ROLLBACK");
        exit;
    }
<<<<<<< HEAD
=======

    $insertInfoQuery = "INSERT INTO hospital_info (hospital_street, hospital_plus_code, contact_number, email, hospital_admin_id, hospital_id) VALUES ($1, $2, $3, $4 ,$5, $6)";
    $result_insert_info = pg_query_params($db_connection, $insertInfoQuery, array($hospital_street, $hospital_plus_code, $hospital_contact, $hospital_email,$AdminID,$hospital_id));
    if (!$result_insert_info) {
        echo "Error inserting log: " . pg_last_error($db_connection);
        pg_query($db_connection, "ROLLBACK");
        exit;
    }

    // Commit the transaction
    pg_query($db_connection, "COMMIT");

    // Redirect
    $_SESSION['add-hospital'] = "New hospital added successfully!";
    header("Location: ../../../hospital-information.php");
    exit();
}

pg_close($db_connection);
=======
                        if (!$result_insert_equipment) {
                        }
                    } 
                }
             
            }
        } 
         
            $log_timestamp = date("Y-m-d");
            $log_action = "New hospital added"; // Your desired log action
>>>>>>> 81ca0a6599ccc9ee6ed200bc17a9de80eb32573a

    $insertInfoQuery = "INSERT INTO hospital_info (hospital_street, hospital_plus_code, contact_number, email, hospital_admin_id, hospital_id) VALUES ($1, $2, $3, $4 ,$5, $6)";
    $result_insert_info = pg_query_params($db_connection, $insertInfoQuery, array($hospital_street, $hospital_plus_code, $hospital_contact, $hospital_email,$AdminID,$hospital_id));
    if (!$result_insert_info) {
        echo "Error inserting log: " . pg_last_error($db_connection);
        pg_query($db_connection, "ROLLBACK");
        exit;
    }

    // Commit the transaction
    pg_query($db_connection, "COMMIT");

    // Redirect
    $_SESSION['add-hospital'] = "New hospital added successfully!";
    header("Location: ../../../hospital-information.php");
    exit();
}

<<<<<<< HEAD
pg_close($db_connection);
=======
>>>>>>> 993da59d339990ba8278087458421d2421015709
>>>>>>> 81ca0a6599ccc9ee6ed200bc17a9de80eb32573a
?>