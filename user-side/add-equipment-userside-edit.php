<?php
session_start();

if (!isset($_SESSION['repo_user_id']) || empty($_SESSION['repo_user_id']) ||
    !isset($_SESSION['hospital_id']) || empty($_SESSION['hospital_id'])) {
    header("Location: login.php");
    exit;
}

include('../includes/config.php');

// Fetch the equipment ID from the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Invalid equipment ID.";
    exit;
}

$equipmentID = $_GET['id'];
$hospitalID = $_SESSION['hospital_id'];

// Fetch equipment data
$query = "SELECT * FROM hospital_equipment_user_side WHERE equipment_id = $1 AND hospital_id = $2";
$result = pg_query_params($db_connection, $query, array($equipmentID, $hospitalID));

if (!$result) {
    echo "Query execution failed: " . pg_last_error($db_connection);
    exit;
}

$equipment = pg_fetch_assoc($result);

if (!$equipment) {
    echo "No equipment found with the given ID.";
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
        .table tbody tr:hover {
            background-color: #f5f5f5;
            cursor: pointer;
        }
        .table tbody tr:hover td {
            color: blue;
        }
        #hidebtn {
            display: none;
        }
        table {
            width: 100%;
            table-layout: fixed;
        }
        th, td {
            padding: 8px;
            text-align: center;
            max-height: 100px;
            overflow: auto;
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
                                <h3 class="page-title">Edit Equipment</h3>
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
                    </div>

                    <!-- FORM FOR EDITING EQUIPMENT -->
                    <form id="editEquipmentForm" method="POST" action="update-equipment.php" enctype="multipart/form-data">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="hospital-equipment">Medical Equipment</label>
                                <input type="text" name="hospital_equipment" class="form-control" value="<?php echo htmlspecialchars($equipment['equipment_name']); ?>" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="hospital-equipment">Description</label>
                                <textarea name="hospital_equipment_description" class="form-control" rows="1" required><?php echo htmlspecialchars($equipment['description']); ?></textarea>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="purchase-date">Purchase Date</label>
                                <input type="date" name="purchase_date" class="form-control" value="<?php echo htmlspecialchars($equipment['purchase_date']); ?>" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="location">Location in the Hospital</label>
                                <input type="text" name="location" class="form-control" value="<?php echo htmlspecialchars($equipment['location']); ?>" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="serial-number">Serial Number</label>
                                <input type="text" name="serial_number" class="form-control" value="<?php echo htmlspecialchars($equipment['serial_number']); ?>" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="model-number">Model Number</label>
                                <input type="text" name="model_number" class="form-control" value="<?php echo htmlspecialchars($equipment['model_number']); ?>" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="equipment-status">Equipment Status</label>
                                <select name="equipment_status" class="form-control" required>
                                    <option value="" disabled>Select Equipment Status</option>
                                    <option value="Available" <?php echo ($equipment['equipment_status'] == 'Available') ? 'selected' : ''; ?>>Available</option>
                                    <option value="In Use" <?php echo ($equipment['equipment_status'] == 'In Use') ? 'selected' : ''; ?>>In Use</option>
                                    <option value="Under Maintenance" <?php echo ($equipment['equipment_status'] == 'Under Maintenance') ? 'selected' : ''; ?>>Under Maintenance</option>
                                    <option value="Out of Order" <?php echo ($equipment['equipment_status'] == 'Out of Order') ? 'selected' : ''; ?>>Out of Order</option>
                                    <option value="Needs Replacement" <?php echo ($equipment['equipment_status'] == 'Needs Replacement') ? 'selected' : ''; ?>>Needs Replacement</option>
                                    <option value="Other" <?php echo ($equipment['equipment_status'] == 'Other') ? 'selected' : ''; ?>>Other</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Image</label>
                                <input name="image" type="file" class="form-control">
                            </div>
                        </div>
                        <input type="hidden" name="equipment_id" value="<?php echo htmlspecialchars($equipmentID); ?>">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" onclick="window.history.back();">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/jquery.slimscroll.min.js"></script>
    <script src="../assets/js/select2.min.js"></script>
    <script src="../assets/js/moment.min.js"></script>
    <script src="../assets/js/bootstrap-datetimepicker.min.js"></script>
    <script src="../assets/js/jquery.dataTables.min.js"></script>
    <script src="../assets/js/dataTables.bootstrap4.min.js"></script>
    <script src="../assets/js/app.js"></script>
</body>

</html>
