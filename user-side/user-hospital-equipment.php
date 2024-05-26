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

require('../fpdf186/fpdf.php'); // Include the FPDF library

// Ensure database connection is established
// $db_connection = pg_connect("your_connection_string");
// Generate PDF
// Generate PDF
if (isset($_POST['generate_pdf'])) {
    // Ensure hospital name is set
    $hospital_name = $_SESSION['hospital_name'] ?? '';

    // Get hospital ID from session
    $hospital_id = $_SESSION['hospital_id'] ?? '';

    // Updated query with JOIN and WHERE clause to filter by hospital ID
    $query = "SELECT hgi.hospital_name, heus.equipment_name, heus.description, heus.purchase_date, heus.location, heus.equipment_status
              FROM hospital_equipment_user_side heus
              JOIN public.hospital_general_information hgi ON heus.hospital_id = hgi.hospital_id
              WHERE heus.hospital_id = $1"; // Use parameterized query for safety

    // Execute the query with hospital ID as parameter
    $result = pg_query_params($db_connection, $query, array($hospital_id));

    // Check if query was successful
    if ($result) {
        // Initialize PDF
        $pdf = new FPDF();
        $pdf->AddPage();

        // Set font
        $pdf->SetFont('Arial','B',16);
        $pdf->Cell(0, 10, 'Equipment Data for ' . $hospital_name, 0, 1, 'C');

        // Add column headers
        $pdf->SetFont('Arial','B',7);
        $pdf->Cell(60,10,'Hospital Name',1,0,'C');
        $pdf->Cell(25,10,'Equipment Name',1,0,'C');
        $pdf->Cell(25,10,'Description',1,0,'C');
        $pdf->Cell(25,10,'Purchase Date',1,0,'C');
        $pdf->Cell(25,10,'Location',1,0,'C');
        $pdf->Cell(25,10,'Equipment Status',1,1,'C');

        // Set font for data
        $pdf->SetFont('Arial','',7);

        // Fetch data and add to PDF
        while ($row = pg_fetch_assoc($result)) {
            $pdf->Cell(60,10,$row['hospital_name'],1,0,'C');
            $pdf->Cell(25,10,$row['equipment_name'],1,0,'C');
            $pdf->Cell(25,10,$row['description'],1,0,'C');
            $pdf->Cell(25,10,$row['purchase_date'],1,0,'C');
            $pdf->Cell(25,10,$row['location'],1,0,'C');
            $pdf->Cell(25,10,$row['equipment_status'],1,1,'C');
        }

        // Close the database connection
        pg_free_result($result);
        pg_close($db_connection);

        // Output PDF content
        $pdf->Output('D', 'equipment_data.pdf'); // 'D' option forces download
        exit;
    } else {
        // Handle query error
        echo "Error: " . pg_last_error($db_connection);
    }
}


if (isset($_POST['generate_csv'])) {
    // Ensure hospital name is set
    $hospital_name = $_SESSION['hospital_name'] ?? '';

    // Get hospital ID from session
    $hospital_id = $_SESSION['hospital_id'] ?? '';

    // Updated query with JOIN and filtering by hospital IDs
    $query = "SELECT hgi.hospital_name, heus.equipment_name, heus.description, heus.purchase_date, heus.location, heus.equipment_status
              FROM hospital_equipment_user_side heus
              JOIN public.hospital_general_information hgi ON heus.hospital_id = hgi.hospital_id
              WHERE heus.hospital_id = $1"; // Correctly use parameterized query

    // Execute the query with hospital ID as parameter
    $result = pg_query_params($db_connection, $query, array($hospital_id));

    // Check if query was successful
    if ($result) {
        // Initialize CSV content with column headers
        $csv_content = "Hospital Name, Equipment Name, Description, Purchase Date, Location, Equipment Status\n";

        // Fetch all rows and append to CSV content
        while ($row = pg_fetch_assoc($result)) {
            // Append row data to CSV content
            $csv_content .= "{$row['hospital_name']}, {$row['equipment_name']}, {$row['description']}, {$row['purchase_date']}, {$row['location']}, {$row['equipment_status']}\n";
        }

        // Close the database connection
        pg_free_result($result);
        pg_close($db_connection);

        // Set headers for CSV download
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="equipment_data.csv"');

        // Output CSV content
        echo $csv_content;
        exit;
    } else {
        // Handle query error
        echo "Error: " . pg_last_error($db_connection);
    }
}

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
        color: blue;
        /* Change text color on hover */
    }
    #hidebtn {
        display: none;
    }

    table {
        width: 100%;
        table-layout: fixed; /* Set table layout to fixed */
    }
    th, td {
        padding: 8px; /* Add padding for better readability */
        text-align: center; /* Align text to the left */
        max-height: 100px; /* Set maximum height for table cells */
        overflow: auto; /* Add scrollbar if content exceeds maximum height */
    }
    </style>
</head>

<body>
    <div class="main-wrapper">

        <?php include_once("user-header.php"); ?>
        <?php include_once("user-sidebar.php"); ?>
        <?php include_once("add-equipment-userside.php"); ?>


        <div class="page-wrapper">
            <div class="content container-fluid">
                <div class="body-container">

                    <!-- HEADER -->
                    <div class="page-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="page-title">Equipment Report</h3>
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
                                <button type="button" class="btn add-btn" data-toggle="modal" data-target="#add_equipment_userside"><i class="fa fa-medkit"></i>Add Equipment</button>                                                      
                            </div>
                                <div class="col-auto">
                                    <div class="dropdown">
                                    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                            <button class="btn export-btn dropdown-toggle" type="button"
                                                id="hide-on-print" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fa fa-download"></i> Export
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="exportDropdown">
                                                <li><button type="submit" class="dropdown-item"
                                                        name="generate_pdf">Export
                                                        Data as PDF</button></li>
                                                <li><button type="submit" class="dropdown-item"
                                                        name="generate_csv">Export
                                                        Data as CSV</button></li>
                                            </ul>
                                            </form>
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
                                            <th>Equipment Name</th>
                                            <th>Description</th>
                                            <th>Purchase-date</th>
                                            <th>Location</th>
                                            <th>Equipment Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
            // Display equipment data in HTML table
            if (!$db_connection) {
                echo "Failed to connect to the database.";
            } else {
                // Check if hospital ID is set in session
                if (!isset($_SESSION['hospital_id']) || empty($_SESSION['hospital_id'])) {
                    echo "Hospital ID not found in session.";
                } else {
                    // Get hospital ID from session
                    $hospital_id = $_SESSION['hospital_id'];

                    // Prepare and execute the query
                    $query = "SELECT equipment_id, equipment_name, description, purchase_date, location, equipment_status 
                            FROM hospital_equipment_user_side 
                            WHERE hospital_id = $1";
                    $result = pg_query_params($db_connection, $query, array($hospital_id));

                    if (!$result) {
                        echo "Query execution failed: " . pg_last_error($db_connection);
                    } else {
                        // Fetch and display results
                        while ($row = pg_fetch_assoc($result)) {
                            if (isset($row['equipment_id']) && !empty($row['equipment_id'])) {
                                $equipmentID = htmlspecialchars($row['equipment_id']);
                                echo "<tr>";
                                echo "<td class='equipment-name'>" . htmlspecialchars($row['equipment_name']) . "</td>";
                                echo "<td class='description'>" . htmlspecialchars($row['description']) . "</td>";
                                echo "<td class='purchase-date'>" . htmlspecialchars($row['purchase_date']) . "</td>";
                                echo "<td class='location'>" . htmlspecialchars($row['location']) . "</td>";
                                echo "<td class='equipment-status'>" . htmlspecialchars($row['equipment_status']) . "</td>";
                                echo "<td class='action'><a href='add-equipment-userside-edit.php?id=$equipmentID' class='btn text-xs text-white btn-blue action-icon'><i class='fa fa-pencil'></i></a></td>";
                                echo "</tr>";
                            } else {
                                echo "<tr><td colspan='6'>Equipment ID missing for this row.</td></tr>";
                            }
                        }
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tableexport/5.2.0/tableexport.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="./assets/js/print.js"></script>

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