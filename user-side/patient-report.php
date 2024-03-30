<?php
session_start();
//SESSION para sa hospital name
$hospital_name = $_SESSION['hospital_name'];
//VERY IMPORTANT
if (!isset($_SESSION['repo_user_id']) || empty($_SESSION['repo_user_id'])) {
    header("Location: login.php");
    exit; 
}
error_reporting(0);
include('../includes/config.php');
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
    body {
        background-color: #D4DEDB;
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

    .print-btn,
    .export-btn {
        padding: 8px 20px;
        background-color: #E5F6F1;
        color: #204A3D;
        border: 1px solid #204A3D;
    }

    .add-btn {
        border-radius: 5px;
        padding: 8px 2rem;
    }

    .m-right {
        margin-right: -0.8rem;
    }
    /* Add hover effect to table rows */
/* Add hover effect to table rows */
.table tbody tr:hover {
    background-color: #f5f5f5;
    cursor: pointer;
}

/* Add hover effect to text within table cells */
.table tbody tr:hover td {
    color: blue; /* Change text color on hover */
}


    </style>
</head>

<body>
    <div class="main-wrapper">

        <?php include_once("user-header.php"); ?>
        <?php include_once("user-sidebar.php"); ?>

        <div class="page-wrapper">
            <div class="content container-fluid">
                <div class="body-container">

                    <!-- HEADER -->
                    <div class="page-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="page-title">Patient Reports</h3>
                            </div>
                        </div>
                    </div>

                    <!-- SEARCH -->
                    <div class="row">
                        <div class="col-md-3">
                            <div class="search-container">
                                <i class="fa fa-search"></i>
                                <input type="text" class="form-control pl-5 search-input" id="searchInput"
                                    placeholder="Search">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <!-- Empty Space -->
                        </div>

                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-auto  ml-auto m-right">
                                    <button class="btn export-btn">
                                        <i class="fa fa-download"></i> Export
                                    </button>
                                </div>
                               
                            </div>
                        </div>
                    </div>
                    <!-- TABLE -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped custom-table datatable" id="logTable">
                                    <thead>
                                        <tr>
                                            <th>Log-id</th>
                                            <th>Patient Case</th>
                                            <th>Date</th>
                                            <th>Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php                                   
                                        //FUNCTION NG CODE NA TO IS TO FETCH THE LOGS DOON SA REPO-LOGS SABAY
                                        //ILALAGAY DITO SA TABLE
                                        //THE ONLY LOGS THAT WILL APPEAR IS IF SAME NG REPO_USER_ID YUNG SUBMITTER
                                        //TYAKA NAKA SESSION NA REPO_USER
                                        $query_hospital = "SELECT hospital_id FROM hospital_general_information WHERE hospital_name = $1";
                                        $result_hospital = pg_query_params($db_connection, $query_hospital, array($hospital_name));
                                        $row_hospital = pg_fetch_assoc($result_hospital);
                                        $hospital_id = $row_hospital['hospital_id'];
                                        // Fetching logs para sa ilalagay sa table nasa script sa baba yung code function
                                        $current_repo_user_id = $_SESSION['repo_user_id'];
                                        $query = "SELECT repository_log_id, patient_case_number, log_timestamp AS date, log_action AS description, 
                                                         completed_by_lname, completed_by_fname, completed_by_mname, designation, patient_id
                                                  FROM repository_logs
                                                  WHERE hospital_id = $1";
                                        //query para sa satinization
                                        $result = pg_query_params($db_connection, $query, array($hospital_id));
                                        //populating tables with clickable link para sa extra info nung logs
                                        if ($result) {
                                            while ($row = pg_fetch_assoc($result)) {
                                                echo "<tr class='log-details' 
                                                      data-log-id='" . htmlspecialchars($row['repository_log_id']) . "'
                                                      data-repo-user-id='" . htmlspecialchars($current_repo_user_id) . "'
                                                      data-patient-id='" . htmlspecialchars($row['patient_id']) . "'
                                                      data-completed-by='" . htmlspecialchars($row['completed_by_lname'] . ' ' . $row['completed_by_fname'] . ' ' . $row['completed_by_mname']) . "'
                                                      data-designation='" . htmlspecialchars($row['designation']) . "'
                                                      data-patient-case-number='" . htmlspecialchars($row['patient_case_number']) . "'
                                                      data-log-timestamp='" . htmlspecialchars($row['date']) . "'
                                                      data-log-action='" . htmlspecialchars($row['description']) . "'>";
                                                echo "<td>" . htmlspecialchars($row['repository_log_id']) . "</td>";
                                                echo "<td>" . htmlspecialchars($row['patient_case_number']) . "</td>";
                                                echo "<td>" . htmlspecialchars($row['date']) . "</td>";
                                                echo "<td>" . htmlspecialchars($row['description']) . "</td>";
                                                echo "</tr>";
                                            }
                                            pg_free_result($result);
                                        } else {
                                        }
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
    <div class="modal fade" id="logModal" tabindex="-1" role="dialog" aria-labelledby="logModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logModalLabel">Log Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="logDetailsBody">
                <!-- para sa extra log details using modal -->
                <div class="row">
                    <div class="col-md-12">
                        <label for="logId">Log ID:</label>
                        <input type="text" class="form-control" id="logId" readonly>
                    </div>
                    <div class="col-md-12">
                        <label for="repoUserId">Repository User ID:</label>
                        <input type="text" class="form-control" id="repoUserId" readonly>
                    </div>
                    <div class="col-md-12">
                        <label for="patientId">Patient ID:</label>
                        <input type="text" class="form-control" id="patientId" readonly>
                    </div>
                    <div class="col-md-12">
                        <label for="completedBy">Completed By:</label>
                        <input type="text" class="form-control" id="completedBy" readonly>
                    </div>
                    <div class="col-md-12">
                        <label for="designation">Designation:</label>
                        <input type="text" class="form-control" id="designation" readonly>
                    </div>
                    <div class="col-md-12">
                        <label for="patientCaseNumber">Patient Case Number:</label>
                        <input type="text" class="form-control" id="patientCaseNumber" readonly>
                    </div>
                    <div class="col-md-12">
                        <label for="logTimestamp">Log Timestamp:</label>
                        <input type="text" class="form-control" id="logTimestamp" readonly>
                    </div>
                    <div class="col-md-12">
                        <label for="logAction">Log Action:</label>
                        <input type="text" class="form-control" id="logAction" readonly>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    

    <script>
        //fetcing sa mga data na ilalagay sa modal
         $(document).ready(function() {
        $('.log-details').click(function(e) {
            e.preventDefault();
            var logId = $(this).data('log-id');
            var repoUserId = $(this).data('repo-user-id');
            var patientId = $(this).data('patient-id');
            var completedBy = $(this).data('completed-by');
            var designation = $(this).data('designation');
            var patientCaseNumber = $(this).data('patient-case-number');
            var logTimestamp = $(this).data('log-timestamp');
            var logAction = $(this).data('log-action');
            // Set values sa modal
            $('#logId').val(logId);
            $('#repoUserId').val(repoUserId);
            $('#patientId').val(patientId);
            $('#completedBy').val(completedBy);
            $('#designation').val(designation);
            $('#patientCaseNumber').val(patientCaseNumber);
            $('#logTimestamp').val(logTimestamp);
            $('#logAction').val(logAction);
            // Show the modal ito yung clicking part
            $('#logModal').modal('show');
        });
    });
    //-------end--------


    //search function
    $(document).ready(function() {
        $('#searchInput').keyup(function() {
            var searchText = $(this).val().toLowerCase();

            $('tbody tr').each(function() {
                var logId = $(this).find('td:eq(0)').text().toLowerCase();
                var patientId = $(this).find('td:eq(1)').text().toLowerCase();
                var date = $(this).find('td:eq(2)').text().toLowerCase();
                var description = $(this).find('td:eq(3)').text().toLowerCase();

                if (
                    logId.includes(searchText) ||
                    patientId.includes(searchText) ||
                    date.includes(searchText) ||
                    description.includes(searchText)
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