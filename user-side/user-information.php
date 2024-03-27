<?php
session_start();

//VERY IMPORTANT DONT ERASE
if (!isset($_SESSION['admin_id']) || empty($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;   
}
error_reporting(0);
include('../includes/config.php');
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

    <!-- Sweetalert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@latest/dist/sweetalert2.min.css">

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
                                <h3 class="page-title">User Information</h3>
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
                                    <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_hospital">
                                        <i class="fa fa-medkit"></i> Add User
                                    </a>
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
                                <table class="table table-striped custom-table datatable" id="imformationTable">
                                    <thead>
                                        <tr>
                                            <th>First Name</th>
                                            <th>Middle Name</th>
                                            <th>Last Name</th>
                                            <th>Hospital Affiliated With</th>
                                            <th>Position</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
       
        if (!$db_connection) {
            echo "Failed to connect to the database.";
        } else {
            $query = "SELECT 
                        ru.repo_user_id,
                        ru.user_fname AS \"First Name\",
                        ru.user_mname AS \"Middle Name\",
                        ru.user_lname AS \"Last Name\",
                        hgi.hospital_name AS \"Hospital Affiliated With\",
                        ru.position AS \"Position\",
                        ru.email AS \"Email\",
                        ru.password AS \"Password\"
                    FROM 
                        repo_user ru
                    JOIN 
                        hospital_general_information hgi ON ru.hospital_id = hgi.hospital_id";

            $result = pg_query($db_connection, $query);                                    
            while ($row = pg_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td class='first-name'>" . $row['First Name'] . "</td>";
                echo "<td class='middle-name'>" . $row['Middle Name'] . "</td>";
                echo "<td class='last-name'>" . $row['Last Name'] . "</td>";
                echo "<td class='hospital-affiliated'>" . $row['Hospital Affiliated With'] . "</td>";
                echo "<td class='user-position'>" . $row['Position'] . "</td>";
                
                // Hidden input fields for additional data within the table row
                echo "<input type='hidden' class='user-email' value='" . $row['Email'] . "'>";
                echo "<input type='hidden' class='user-password' value='" . $row['Password'] . "'>";
                
                echo "<td>";
                echo "<a href='#' data-toggle='modal' data-target='#edit_user' title='Edit' class='btn text-xs text-white btn-blue edituser-action' data-repo-id='" . $row['repo_user_id'] . "'><i class='fa fa-pencil'></i></a>";
                echo "<a href='#' data-toggle='modal' data-target='#delete_user' title='Delete' class='btn text-xs text-white btn-danger delete-action ml-2' data-repo-id='" . $row['repo_user_id'] . "'><i class='fa fa-trash'></i></a>";
                echo "</td>";
                echo "</tr>";
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

            <!-- Add User Modal -->
            <?php include_once '../includes/modals/hospital/add_user.php'; ?>

            <!-- Edit Hospital Modal -->
            <?php include_once '../includes/modals/hospital/edit_user.php'; ?>

            <!-- Delete Hospital Modal -->
            <?php include_once '../includes/modals/hospital/delete_user.php'; ?>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#searchInput').keyup(function() {
            var searchText = $(this).val().toString().toLowerCase();

            $('tbody tr').each(function() {
                var firstName = $(this).find('.first-name').text().toLowerCase();
                var middleName = $(this).find('.middle-name').text().toLowerCase();
                var lastName = $(this).find('.last-name').text().toLowerCase();
                var hospitalAffiliated = $(this).find('.hospital-affiliated').text()
                    .toLowerCase();
                var userPosition = $(this).find('.user-position').text().toLowerCase();

                if (
                    firstName.includes(searchText) ||
                    middleName.includes(searchText) ||
                    lastName.includes(searchText) ||
                    hospitalAffiliated.includes(searchText) ||
                    userPosition.includes(searchText)
                ) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
    });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tableexport/5.2.0/tableexport.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>


    
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







    <!-- Include SweetAlert library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@latest"></script>

    <script>
    function addUser(success) {
        swal.fire({
            title: 'Success!',
            text: success,
            icon: 'success',
            confirmButtonText: 'OK'
        });
    }


    function userCreated(error) {
        swal.fire({
            title: 'Error!',
            text: error,
            icon: 'error',
            confirmButtonText: 'OK'
        });
    }

    document.addEventListener('DOMContentLoaded', function() {

        <?php
        if (isset($_SESSION['add-user'])) {
            $success = $_SESSION['add-user'];
            // Clear the session variable
            unset($_SESSION['add-user']);

            // Call the function to display success message
            echo "addUser('$success');";
        }
        ?>

<?php
        if (isset($_SESSION['user-created'])) {
            $error = $_SESSION['user-created'];
            // Clear the session variable
            unset($_SESSION['user-created']);

            // Call the function to display success message
             echo "userCreated('$error');";
        }
        ?>


    });
    </script>

</body>

</html>