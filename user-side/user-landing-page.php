<?php
session_start();

error_reporting(0);

//VERY IMPORTANT DONT ERASE
if (!isset($_SESSION['repo_user_id']) || empty($_SESSION['repo_user_id'])) {
    header("Location: login.php");
    exit;
}
//connection sa database
include('../includes/config.php');


//extra function para sa database
try {
    $dbh = new PDO("pgsql:" . $host);
} catch (PDOException $e) {

}
//fectinng yung repo user id
$repo_user_id = $_SESSION['repo_user_id'];
//-------end--------



//Querying yung mga Patient na same Hospital with the current in-session Repo user, then ilalagay sa table 
//Nasa table sa baba yung next query nitong function nato hahaha
$query_affiliation = "SELECT hgi.hospital_name
                      FROM repo_user ru
                      JOIN hospital_general_information hgi ON ru.hospital_id = hgi.hospital_id
                      WHERE ru.repo_user_id = '$repo_user_id'::uuid";
$result_affiliation = pg_query($db_connection, $query_affiliation);
if (!$result_affiliation) {
    exit;
}
//result and fetcing nung hospitalname based sa query sa taas
$row_affiliation = pg_fetch_assoc($result_affiliation);
$hospital_name = $row_affiliation['hospital_name'];
$_SESSION['hospital_name'] = $hospital_name;
//Querying yung total count ng patient para i display sa Metrics
$query_hospital_id = "SELECT hospital_id FROM repo_user WHERE repo_user_id = '$repo_user_id'::uuid";
$result_hospital_id = pg_query($db_connection, $query_hospital_id);
//iniitializing yung hospital id
$row_hospital_id = pg_fetch_assoc($result_hospital_id);
$hospital_id = $row_hospital_id['hospital_id'];

// Checking kung empty yung hospital ID
if (empty($hospital_id)) {
    exit;
}
//-------end--------



//Function para makita kung ilang yung count ng total entries
$query_total_patients = "SELECT COUNT(*) AS total_patients FROM cancer_cases_general_info WHERE hospital_id = '$hospital_id'::uuid";
$result_total_patients = pg_query($db_connection, $query_total_patients);

// Check kung yung $result is empty
if (!$result_total_patients) {
    exit;
}
//variable totalpatients na ilalagay sa metric sa baba
$row_total_patients = pg_fetch_assoc($result_total_patients);
$total_patients = $row_total_patients['total_patients'];
//-------end--------



//query para sa mga new patient metric
$sql = "SELECT COUNT(patient_id) AS new_patient 
FROM cancer_cases_general_info 
WHERE time_stamp >= CURRENT_TIMESTAMP - INTERVAL '10 minutes' 
AND hospital_id = (SELECT hospital_id FROM repo_user WHERE repo_user_id = $1)"; 
//parameters 
$result = pg_query_params($db_connection, $sql, array($_SESSION['repo_user_id']));
//Checking kung tama and hindi empty yung query
if (!$result) {
    exit;
}
// Fetching yung result
$row = pg_fetch_assoc($result);
// Extract the new patient count
$new_patient = isset($row['new_patient']) ? $row['new_patient'] : 0;
//-------end--------
?>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="This is a Philippine Cancer Repository System">
    <meta name="keywords" content="PCC-CR, CR, Cancer Repository, Capstone, System, Repo">
    <meta name="author" content="Heionim">
    <meta name="robots" content="noindex, nofollow">
    <title>PCC CANCER REPOSITORY</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="../profiles/pcc-logo1.png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="../assets/css/font-awesome.min.css">

    <!-- Lineawesome CSS -->
    <link rel="stylesheet" href="../assets/css/line-awesome.min.css">

    <!-- Datatable CSS -->
    <link rel="stylesheet" href="../assets/css/dataTables.bootstrap4.min.css">

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="../assets/css/select2.min.css">

    <!-- Datetimepicker CSS -->
    <link rel="stylesheet" href="../assets/css/bootstrap-datetimepicker.min.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">

    <style>
        .page-header {
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 5px;
            color: #fff;
        }

        .page-header .breadcrumb-item.active,
        .page-header .welcome h3 {
            color: #204A3D;
            font-size: 2rem;
            font-weight: 700;
        }

        .body-container {
            background-color: #FAFAFA;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        }

        table {
            text-align: center;
            border: 1px solid #285D4D;
        }

        .page-title {
            font-size: 1.3rem;
            color: #204A3D;
            font-weight: 900;
        }

        .btn-blue {
            background-color: #0D6EFD;
        }

        .search-container {
            position: relative;
        }

        .search-input {
            border: none;
            border-radius: 5px;
            width: 100%;
            border: 1px solid #9E9E9E;
            margin-bottom: 20px;
        }

        .search-input:focus {
            outline: none;
        }

        .search-container i {
            position: absolute;
            left: 15px;
            top: 45%;
            transform: translateY(-50%);
            color: #888;
        }

        .filter-btn {
            padding: 8px 20px;
            background-color: #E5F6F1;
            color: #204A3D;
            border: 1px solid #204A3D;
            display: flex;
            justify-content: space-around;
        }

        .add-btn {
            border-radius: 5px;
            padding: 8px 2rem;
        }

        .m-right {
            margin-right: -0.8rem;
        }

        .card-body {
            height: 180px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 0.5rem;
        }

        .card-body h3 {
            font-weight: 700;
        }

        .card-body .span-text {
            font-size: 1.2rem;
            font-weight: 900;
        }
    </style>
</head>

<body>
    <!-- Main Wrapper -->
    <div class="main-wrapper">

        <?php include("user-header.php"); ?>
        <?php include("user-sidebar.php"); ?>

        <div class="page-wrapper">
            <div class="content container-fluid">

                <!-- WELCOME MESSAGE -->
                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="welcome d-flex justify-content-between align-items-center">
                                <h3 class="page-title"><?php echo $hospital_name; ?> Repository</h3>

                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item active"></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- METRICS -->
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-6">
                        <div class="card dash-widget">
                            <div class="card-body">
                                <span class="dash-widget-icon"><i class="fa fa-user"></i></span>
                                <div class="dash-widget-info">
                                    
                                    <h3><?php echo $new_patient; //output ?></h3>
                                    <span class="span-text"><a href="#" id="new-patients-link">New Entries</a></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-6">
                        <div class="card dash-widget">
                            <div class="card-body">
                                <span class="dash-widget-icon"><i class="fa fa-users"></i></span>
                                <div class="dash-widget-info">
                                    <h3><?php echo $total_patients; //output ?></h3>
                                    <span class="span-text"><a href="#" id="total-patients-link">Total Entries</a></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- PATIENT INFO -->
                <div class="body-container">

                    <!-- SEARCH -->
                    <div class="row mr-2">
                        <div class="col-md-3">
                            <div class="col">
                                <h1 class="page-title">Cases Info</h1>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <!-- Empty Space -->
                        </div>

                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-5 ml-auto m-right">
                                    <div class="search-container ">
                                        <i class="fa fa-search"></i>
                                        <input type="text" class="form-control pl-5 search-input" id="searchInput" placeholder="Search">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- TABLE -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped custom-table datatable">
                                    <thead>
                                        <tr>
                                            <th>Case Number</th>
                                            <th>Gender</th>
                                            <th>Age</th>
                                            <th>Cancer</th>
                                            <th>Cancer Stage</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        //FUNCTION NG CODE NA TO IS:
                                        //KUKUHAIN NYA KUNG ANONG HOSPITAL NI CURRENT REPO_USER LOGIN SESSION
                                        //THEN I S-SAVE YUNG HOSPITAL-ID
                                        //THEN I QUERY KUNG ANONG PATIENT IS YUNG EQUAL DOON SA HOSPITAL-ID NA YON AT AYON YUNG I D-DISPLAY SA TABLE
                                        if (!$db_connection) {
                                        } else {
                                            $repo_user_id = $_SESSION['repo_user_id'];
                                            //QUERY PARA SA HOSPITAL ID THE I S-SAVE AS $HOSPITAL_ID
                                            $query_affiliation = "SELECT hospital_id FROM repo_user WHERE repo_user_id = '$repo_user_id'";
                                            $result_affiliation = pg_query($db_connection, $query_affiliation);
                                            //CHECKING IF WALANG RESULT          
                                            if (!$result_affiliation) {
                                                exit;
                                            }
                                            //FETCHING THE hospital_id
                                            $row_affiliation = pg_fetch_assoc($result_affiliation);
                                            $hospital_id = $row_affiliation['hospital_id'];
                                            //-------end--------
                                            
                                            
                                            // PUTANG INANG SQL JOIN TO PUTANG INA MO
                                            $query = "SELECT
                                                        ccgi.patient_id,
                                                        ccgi.patient_case_number,
                                                        ccgi.sex,
                                                        ccgi.age,
                                                        ccgi.primary_site,
                                                        ccgi.cancer_stage,
                                                        ccgi.patient_status
                                                    FROM
                                                        cancer_cases_general_info ccgi
                                                    JOIN
                                                        hospital_general_information hgi ON ccgi.hospital_id = hgi.hospital_id
                                                    WHERE
                                                        ccgi.hospital_id = '$hospital_id'";
                                            //IF QUERY SUCCESSFUL DISPLAY NA SYA SA TABLE                                                                 
                                            $result = pg_query($db_connection, $query);
                                            if (!$result) {
                                                exit;
                                            }
                                            // QUERY DISPLAYING IN TABLE
                                            while ($row = pg_fetch_assoc($result)) {
                                                echo "<td><a href='#' class='edit-patient' data-id='" . $row['patient_id'] . "'>" . $row['patient_case_number'] . "</a></td>";
                                                echo "<td><a href='#' class='edit-patient' data-id='" . $row['patient_id'] . "'>" . $row['age'] . "</a></td>";
                                                echo "<td><a href='#' class='edit-patient' data-id='" . $row['patient_id'] . "'>" . $row['sex'] . "</a></td>";
                                                echo "<td><a href='#' class='edit-patient' data-id='" . $row['patient_id'] . "'>" . $row['primary_site'] . "</a></td>";
                                                echo "<td><a href='#' class='edit-patient' data-id='" . $row['patient_id'] . "'>" . $row['cancer_stage'] . "</a></td>";
                                                echo "<td><a href='#' class='edit-patient' data-id='" . $row['patient_id'] . "'>" . $row['patient_status'] . "</a></td>";
                                                echo "</tr>";
                                            }
                                            
                                            echo "</tbody>";
                                        }

                                        pg_close($db_connection);
                                        //-------end--------
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script>
//Alert papunta sa manage patient gamit yung table sa repo landing page
$(document).ready(function() {
        // Alert papunta sa manage patient
        $('.edit-patient').click(function(e) {
            e.preventDefault();
            var patientId = $(this).data('id');
            Swal.fire({
                title: 'Manage Patient',
                text: 'Redirecting to Manage Patient!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'manage-patient.php';
                }
            });
        });
        //-------end--------


        // Alert papunta sa Cancer Cases Repository gamit yung new patient metric
        $('#new-patients-link').click(function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Cancer Cases Repository',
                text: 'Redirecting to Cancer Cases Repository!',
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'patient-form-v2.php'; 
                }
            });
        });
    });
    //-------end--------


            // Alert papunta sa Cancer Cases Repository gamit yung total link metric
            $('#total-patients-link').click(function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Cancer Cases Repository',
                text: 'Redirecting to Cancer Cases Repository!',
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'patient-form-v2.php'; // Redirect to cancer-cases-repository.php
                }
            });
        });
        //-------end--------


        //search function
        $(document).ready(function() {
            $('#searchInput').keyup(function() {
                var searchText = $(this).val().toLowerCase();

                $('tbody tr').each(function() {
                    var type = $(this).data('type').toLowerCase();
                    var lastname = $(this).data('lastname').toLowerCase();
                    var firstname = $(this).data('firstname').toLowerCase();
                    var gender = $(this).data('gender').toLowerCase();
                    var stage = $(this).data('stage').toLowerCase();
                    var status = $(this).data('status').toLowerCase();

                    if (
                        type.includes(searchText) ||
                        lastname.includes(searchText) ||
                        firstname.includes(searchText) ||
                        gender.includes(searchText) ||
                        stage.includes(searchText) ||
                        status.includes(searchText)
                    ) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
        });
        //-------end--------


    </script>


    <!-- jQuery -->
    <script src="../assets/js/jquery-3.2.1.min.js"></script>

    <!-- Bootstrap Core JS -->
    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>

    <!-- Slimscroll JS -->
    <script src="../assets/js/jquery.slimscroll.min.js"></script>

    <!-- Chart JS -->
    <script src="../assets/js/chart.js"></script>

    <!-- Select2 JS -->
    <script src="../assets/js/select2.min.js"></script>

    <!-- Datetimepicker JS -->
    <script src="../assets/js/moment.min.js"></script>
    <script src="../assets/js/bootstrap-datetimepicker.min.js"></script>

    <!-- Datatable JS -->
    <script src="../assets/js/jquery.dataTables.min.js"></script>
    <script src="../assets/js/dataTables.bootstrap4.min.js"></script>

    <!-- Custom JS -->
    <script src="../assets/js/app.js"></script>
</body>
</html>