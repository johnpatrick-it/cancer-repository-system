<?php
session_start();

// Ensure the admin is logged in
if (!isset($_SESSION['admin_id']) || empty($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Include the configuration file
include('includes/config.php');

// Retrieve the hospital IDs directly associated with the logged-in admin
$admin_id = $_SESSION['admin_id'];
$hospital_ids_query = "
    SELECT hospital_id 
    FROM hospital_general_information 
    WHERE admin_id = $1";
$hospital_ids_result = pg_query_params($db_connection, $hospital_ids_query, [$admin_id]);

if ($hospital_ids_result && pg_num_rows($hospital_ids_result) > 0) {
    $hospital_ids = [];
    while ($row = pg_fetch_assoc($hospital_ids_result)) {
        $hospital_ids[] = $row['hospital_id'];
    }
    // Convert array to a string of comma-separated UUIDs
    $hospital_ids_str = implode("','", $hospital_ids);
    $hospital_ids_str = "'" . $hospital_ids_str . "'";
} else {
    $_SESSION['error'] = 'No hospitals found for this admin.';
    header('Location: dashboard.php');
    exit;
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
                                <input type="text" class="form-control pl-5 search-input" id="searchInput" placeholder="Search">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <!-- Empty Space -->
                        </div>

                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-auto ml-auto m-right">
                                        <a href="#" id="hidebtn" class="add-btn" data-toggle="modal" data-target="#add_hospital"></a>
                                </div>

                                <div class="col-auto">
                                    <div class="dropdown">
                                        <button class="btn export-btn dropdown-toggle" type="button" id="hide-on-print" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa fa-download"></i> Export
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="exportDropdown">
                                            <li><a class="dropdown-item" href="#" onclick="exportTable('pdf')">Export as PDF</a></li>
                                            <li><a class="dropdown-item" href="#" onclick="exportTable('excel')">Export as Excel</a></li>
                                            <li><a class="dropdown-item" href="#" onclick="exportTable('csv')">Export as CSV</a></li>
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
                                            // Fetch equipment data for the retrieved hospital IDs
                                            $query = "
                                                SELECT hgi.hospital_name, heus.equipment_name, heus.description, heus.purchase_date, heus.location, heus.equipment_status
                                                FROM hospital_equipment_user_side heus
                                                JOIN hospital_general_information hgi ON heus.hospital_id = hgi.hospital_id
                                                WHERE heus.hospital_id IN ($hospital_ids_str)";
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

    <!-- JS scripts here -->
</body>

</html>
