<?php
session_start();
//SESSION para sa hospital name
$hospital_name = $_SESSION['hospital_name'];
//VERY IMPORTANT
if (!isset($_SESSION['repo_user_id']) || empty($_SESSION['repo_user_id']) ||
    !isset($_SESSION['hospital_id']) || empty($_SESSION['hospital_id'])) {
    header("Location: login.php");
    exit; 
}

$hospitalID = $_SESSION['hospital_id'];

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
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <title>PCC CANCER REPOSITORY</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="./profiles/pcc-logo1.png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">

    <!-- Lineawesome CSS -->
    <link rel="stylesheet" href="assets/css/line-awesome.min.css">

    <!-- Datatable CSS -->
    <link rel="stylesheet" href="assets/css/dataTables.bootstrap4.min.css">

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="assets/css/select2.min.css">

    <!-- Datetimepicker CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap-datetimepicker.min.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="assets/css/style.css">

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

    .filter-btn,
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

    .modal {
        background-color: rgba(0, 0, 0, 0.4);
    }

    #hidebtn {
        display: none;
    }
    </style>
</head>

<body>
    <div class="main-wrapper">


    <?php include_once("includes/header.php"); ?>
    <?php include_once("includes/sidebar.php"); ?>



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
                                <div class="col-auto ml-auto m-right">
                                <!-- Empty shiit space para hindi umurong -->   
                            </div>
                                <div class="col-auto">
                                    <div class="dropdown">
                                        <button class="btn export-btn dropdown-toggle" type="button" id="hide-on-print"
                                            data-bs-toggle="dropdown" aria-expanded="false"> <i
                                                class="fa fa-download"></i> Export</button>
                                        <ul class="dropdown-menu" aria-labelledby="exportDropdown">
                                            <li><a class="dropdown-item" href="#" onclick="exportTable('pdf')">Export as
                                                    PDF</a>
                                            </li>
                                            <li><a class="dropdown-item" href="#" onclick="exportTable('excel')">Export
                                                    as Excel</a>
                                            </li>
                                            <li><a class="dropdown-item" href="#" onclick="exportTable('csv')">Export as
                                                    CSV</a>
                                            </li>
                                        </ul>
                                    </div>
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
                                            <th>Hospital Name</th>
                                            <th>Equipment Name</th>
                                            <th>Description</th>
                                            <th>Purchase Date</th>
                                            <th>Location</th>
                                            <th>Equipment Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Check database connection
                                        if (!$db_connection) {
                                            echo "Failed to connect to the database.";
                                        } else {
                                            // Execute the query
                                            $query = "
                                                SELECT hgi.hospital_name, heus.equipment_name, heus.description, heus.purchase_date, heus.location, heus.equipment_status
                                                FROM hospital_equipment_user_side heus
                                                JOIN hospital_general_information hgi ON heus.hospital_id = hgi.hospital_id"; // Adjust column and table names as needed
                                            $result = pg_query($db_connection, $query);

                                            if (!$result) {
                                                echo "Query execution failed: " . pg_last_error($db_connection);
                                            } else {
                                                // Fetch and display results
                                                while ($row = pg_fetch_assoc($result)) {
                                                    echo "<tr>";
                                                    echo "<td class='hospital-name'>" . htmlspecialchars($row['hospital_name']) . "</td>";
                                                    echo "<td class='equipment-name'>" . htmlspecialchars($row['equipment_name']) . "</td>";
                                                    echo "<td class='description'>" . htmlspecialchars($row['description']) . "</td>";
                                                    echo "<td class='purchase-date'>" . htmlspecialchars($row['purchase_date']) . "</td>";
                                                    echo "<td class='location'>" . htmlspecialchars($row['location']) . "</td>";
                                                    echo "<td class='equipment-status'>" . htmlspecialchars($row['equipment_status']) . "</td>";
                                                    echo "</tr>";
                                                }
                                            }
                                        }
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