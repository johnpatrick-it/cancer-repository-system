<?php
ob_start(); // Buffer output to prevent "Headers Already Sent" error
session_start();
ini_set('display_errors', 1);

// Check if si user is logged in
if (!isset($_SESSION['repo_user_id']) || empty($_SESSION['repo_user_id'])) {
    //if walang session babalik sya login page
    header("Location: login.php");
    exit;
}
//--------end function---------//



//connection para sa database
include('../includes/config.php');
//--------end function---------//



// Retrieving repo_user_id para session need to para sa pag query ng repo user functions and else
$repo_user_id = $_SESSION['repo_user_id'];

// Retrieving hospital_id para sa current user needed to para sa pag insert query ng hospital id and else
$query_hospital_id = "SELECT hospital_id FROM public.repo_user WHERE repo_user_id = $1";
$result_hospital_id = pg_query_params($db_connection, $query_hospital_id, array($repo_user_id));

if ($result_hospital_id) {
    $row_hospital_id = pg_fetch_assoc($result_hospital_id);
    $hospital_id = $row_hospital_id['hospital_id'];

    // Storing hospital_id sa $hospital_id sesion variable
    $_SESSION['hospital_id'] = $hospital_id;

    // Fetching ng user submitter info from repo_user table
    $query_user_info = "SELECT user_fname, user_lname, user_mname, position FROM public.repo_user WHERE repo_user_id = $1";
    $result_user_info = pg_query_params($db_connection, $query_user_info, array($repo_user_id));
    $row_user_info = pg_fetch_assoc($result_user_info);
    
    // Check if user information is fetched successfully
    if ($row_user_info) {
        // Extract user information
        $first_name = htmlspecialchars($row_user_info['user_fname']);
        $last_name = htmlspecialchars($row_user_info['user_lname']);
        $middle_name = htmlspecialchars($row_user_info['user_mname']);  
        $designation = htmlspecialchars($row_user_info['position']);
    } else {
        exit; // Exiting the script if user information is not found
        
    }
    //--------end function---------//




    //!!!!!ITONG FUCNTION NA 'TO IS HINDI PA TAPOS KULANG PA SYA NG DEATH DATE NG PATIENT KAPAG PATAY NA!!!!! 

    /* Idea ng function na 'to is first pag nag insert ng file yung user i m-make sure nya na makapunta talaga yung file dito sa
    "file-insertion-save.php" kasi ang sakit naman nun! pag nag insert ka ng effort sabay hindi naman pala appreciated yung efforts 
    na binigay mo, edi sayang lang, dagdag lang sa storage nitong project na'to. Kaya minake sure ko dito sa function na 'to, 
    is yung file ay makakapunta talaga sa file-insertion-save.php para happy ending */
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"]) && $_POST["action"] === "file-insertion-save.php") {
        // Checking kung appropriate ba yung file and secure from injection & xxs yung content
        if (isset($_FILES["fileToUpload"]) && $_FILES["fileToUpload"]["error"] == 0) {
            // if appropriate sya and secure the i s-save s'ya sa uploads folder sa loob ng user-side folder
            // pero auto delete yung files dito pag succesful yung insert query
            $target_dir = "uploads/";
            // Path to uploaded file
            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
            // Move uploaded file to specified directory
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                // Opening yung uploaded CSV file "r" stands for read
                $file = fopen($target_file, "r");
                if ($file) {
                    while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
                        // Extracting ng data from CSV or ibang file types
                        $diagnosis_date_str = $data[0];
                        
                        $diagnosis_date = DateTime::createFromFormat('d/m/Y', $diagnosis_date_str);
                        if ($diagnosis_date !== false) {
                            $diagnosis_date = $diagnosis_date->format('Y-m-d');
                        } else {
                            continue;
                        }
        
                        $primary_site = $data[1];
                        $type_of_patient = $data[2];
                        $sex = $data[3];
                        $age = $data[4];
                        $patient_status = $data[5];
                        $cancer_stage = $data[6];
                        $patient_case_number = $data[7];
                        $address_city_municipality = $data[8];

                        $query_insert_patient = "INSERT INTO public.cancer_cases_general_info 
                        (diagnosis_date, primary_site, type_of_patient, sex, age, patient_status, cancer_stage, patient_case_number, address_city_municipality, repo_user_id, hospital_id, completed_by_fname, completed_by_lname, completed_by_mname, designation) 
                        VALUES 
                        ($1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11, $12, $13, $14, $15)
                        RETURNING patient_id";

                            $stmt_insert_patient = pg_prepare($db_connection, "", $query_insert_patient);
                            $result_insert_patient = pg_execute($db_connection, "", array(
                                $diagnosis_date,
                                $primary_site,
                                $type_of_patient,
                                $sex,
                                $age,
                                $patient_status,
                                $cancer_stage,
                                $patient_case_number,
                                $address_city_municipality,
                                $repo_user_id,
                                $hospital_id,
                                $first_name,
                                $last_name,
                                $middle_name,
                                $designation
                            ));

                            if ($result_insert_patient) {
                                $row_insert_patient = pg_fetch_row($result_insert_patient);
                                $patient_id = $row_insert_patient[0];
                                $_SESSION['insertion_success'] = true;
                            }
                            
                            // Perform logs insertion using the retrieved patient_id
                            $log_action = "Cancer Case Inserted";
                            $query_log_success = "INSERT INTO public.repository_logs (log_timestamp, repo_user_id, patient_id, hospital_id, completed_by_lname, completed_by_fname, completed_by_mname, designation, patient_case_number, log_action) VALUES (timezone('Asia/Manila', current_timestamp), $1, $2, $3, $4, $5, $6, $7, $8, $9)";
                            $result_log_success = pg_query_params($db_connection, $query_log_success, array($repo_user_id, $patient_id, $hospital_id, $last_name, $first_name, $middle_name, $designation, $patient_case_number, $log_action));         
                            if (!$result_log_success) {

                            }
                        
                            // File insertion was successful, proceed with unlinking the file
                            unlink($target_file);
                        } 
                    }
                    fclose($file);
                } else {
                    $_SESSION['insertion_success'] = false;
                }
            } else {
                $_SESSION['insertion_success'] = false;
            }
        } else {
            $_SESSION['insertion_success'] = false;
        }
        header("Location: file-insertion.php");
    }

//--------end function---------//


