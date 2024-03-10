<?php
session_start();

if (!isset($_SESSION['admin_id']) || empty($_SESSION['admin_id'])) {
    // Redirect to the login page
    header("Location: login.php");
    exit; 
}

error_reporting(0);
include('includes/config.php');
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
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/pcc-logo.svg">

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
<<<<<<< HEAD

    <!-- Sweetalert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@latest/dist/sweetalert2.min.css">

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
=======
    
    <!-- Sweetalert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@latest/dist/sweetalert2.min.css">
   
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
>>>>>>> b108fa4dc5d6b3645dcc7584571c79bf87a22615
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
                                <h3 class="page-title">Hospital Information</h3>
                            </div>
                        </div>
                    </div>

                    <!-- SEARCH -->
                    <div class="row">
                        <div class="col-md-3">
<<<<<<< HEAD
                            <div class="search-container">
                                <i class="fa fa-search"></i>
                                <input type="text" id="searchInput" class="form-control pl-5 search-input"
                                    placeholder="Search">
=======
                            <div class="search-container"> 
                                <i class="fa fa-search"></i>
                                <input type="text" id="searchInput" class="form-control pl-5 search-input"
                                            placeholder="Search">
>>>>>>> b108fa4dc5d6b3645dcc7584571c79bf87a22615
                            </div>
                        </div>

                        <div class="col-md-3">
                            <!-- Empty Space -->
                        </div>

                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-auto ml-auto m-right">
                                    <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_hospital">
                                        <i class="fa fa-medkit"></i> Add Hospital
                                    </a>
                                </div>
                                <div class="col-auto">
                                    <button class="btn filter-btn  m-right">
                                        <i class="fa fa-filter"></i> Filter
                                    </button>
                                </div>
                                <div class="col-auto">
<<<<<<< HEAD
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

=======
                                <div class="dropdown">
                            <button class="btn export-btn dropdown-toggle" type="button" id="hide-on-print"
                                data-bs-toggle="dropdown" aria-expanded="false"> <i class="fa fa-download"></i> Export</button>
                            <ul class="dropdown-menu" aria-labelledby="exportDropdown">
                                <li><a class="dropdown-item" href="#" onclick="exportTable('pdf')">Export as PDF</a>
                                </li>
                                <li><a class="dropdown-item" href="#" onclick="exportTable('excel')">Export as Excel</a>
                                </li>
                                <li><a class="dropdown-item" href="#" onclick="exportTable('csv')">Export as CSV</a>
                                </li>
                            </ul>
                        </div>
                                    
>>>>>>> b108fa4dc5d6b3645dcc7584571c79bf87a22615
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- TABLE -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
<<<<<<< HEAD
                                <table class="table table-striped custom-table datatable" id="imformationTable">
                                    <thead>
                                        <tr>
                                            <th>Hospital Name</th>
                                            <th>Hospital Level</th>
                                            <th>Type of Instituion</th>
                                            <th>Hospital Location UACS CODE</th>
                                            <th>Hospital Street</th>

=======
                            <table class="table table-striped custom-table datatable" id="imformationTable">
                                    <thead>
                                        <tr>
                                        <th>Hospital Name</th>
                                            <th>Hospital Level</th>
                                            <th>Type of Instituion</th>
                                            <th>Hospital Location UACS CODE</th>
                                            <th>Hospital Street</th> 
                                       
>>>>>>> b108fa4dc5d6b3645dcc7584571c79bf87a22615
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            if (!$db_connection) {
                                                echo "Failed to connect to the database.";
                                            } else {
<<<<<<< HEAD
                                                $query = "SELECT hospital_name, hospital_level, type_of_institution, hospital_barangay, hospital_street FROM hospital_general_information";
                                                $result = pg_query($db_connection, $query);
                                                while ($row = pg_fetch_assoc($result)) {
                                                    echo "<tr data-name='{$row['hospital_name']}' data-level='{$row['hospital_level']}' data-institution='{$row['type_of_institution']}' data-barangay='{$row['hospital_barangay']}' data-street='{$row['hospital_street']}'>";
                                                    echo "<td>" . $row['hospital_name'] . "</td>";
                                                    echo "<td>" . $row['hospital_level'] . "</td>";
                                                    echo "<td>" . $row['type_of_institution'] . "</td>";
                                                    echo "<td>" . $row['hospital_barangay'] . "</td>";
                                                    echo "<td>" . $row['hospital_street'] . "</td>";
=======
                                                $query = "SELECT hospital_id, hospital_name, hospital_level, type_of_institution, hospital_region, hospital_province, hospital_city, hospital_barangay, hospital_street, hospital_equipments FROM hospital_general_information";
                                                $result = pg_query($db_connection, $query);
                                                while ($row = pg_fetch_assoc($result)) {
                                                    echo "<tr>";
                                                    echo "<td class='hospital-name'>" . $row['hospital_name'] . "</td>";
                                                    echo "<td class='hospital-level'>" . $row['hospital_level'] . "</td>";
                                                    echo "<td class='type-of-institution'>" . $row['type_of_institution'] . "</td>";
                                                    echo "<td class='hospital-barangay'>" . $row['hospital_barangay'] . "</td>";
                                                    echo "<td class='hospital-street'>" . $row['hospital_street'] . "</td>";
>>>>>>> b108fa4dc5d6b3645dcc7584571c79bf87a22615
                                                
                                                    // Populate hidden input fields for additional data
                                                    echo "<input type='hidden' class='hospital-region' value='" . $row['hospital_region'] . "'>";
                                                    echo "<input type='hidden' class='hospital-province' value='" . $row['hospital_province'] . "'>";
                                                    echo "<input type='hidden' class='hospital-city' value='" . $row['hospital_city'] . "'>";
                                                    echo "<input type='hidden' class='hospital-streets' value='" . $row['hospital_street'] . "'>";
                                                    echo "<input type='hidden' class='hospital-equipments' value='" . $row['hospital_equipments'] . "'>";
                                                
                                                    echo "<td>";
                                                    echo "<a href='#' data-toggle='modal' data-target='#edit_hospital' title='Edit' class='btn text-xs text-white btn-blue edit-action' data-hospital-id='" . $row['hospital_id'] . "'><i class='fa fa-pencil'></i></a>";
                                                    echo "</td>";
                                                    echo "</tr>";
                                                }
                                                
                                            }
                                            pg_close($db_connection);
<<<<<<< HEAD
                                        ?>
=======
                                        ?>                                       
>>>>>>> b108fa4dc5d6b3645dcc7584571c79bf87a22615
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<<<<<<< HEAD

=======
           
>>>>>>> b108fa4dc5d6b3645dcc7584571c79bf87a22615
            <!-- Add Hospital  Modal -->
            <?php include_once 'includes/modals/hospital/add_hospital.php'; ?>

            <!-- Edit Hospital Modal -->
            <?php include_once 'includes/modals/hospital/edit_hospital.php'; ?>

            <!-- Delete Hospital Modal -->
            <?php include_once 'includes/modals/hospital/delete_hospital.php'; ?>
<<<<<<< HEAD


=======
>>>>>>> b108fa4dc5d6b3645dcc7584571c79bf87a22615
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<<<<<<< HEAD
    <script>
    $(document).ready(function() {
        $('#searchInput').keyup(function() {
            var searchText = $(this).val().toString().toLowerCase();

            $('tbody tr').each(function() {
                var name = $(this).data('name').toString().toLowerCase();
                var level = $(this).data('level').toString().toLowerCase();
                var institution = $(this).data('institution').toString().toLowerCase();
                var barangay = $(this).data('barangay').toString().toLowerCase();
                var street = $(this).data('street').toString().toLowerCase();


                if (
                    name.includes(searchText) ||
                    level.includes(searchText) ||
                    institution.includes(searchText) ||
                    barangay.includes(searchText) ||
                    street.includes(searchText)

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
=======
<script>
$(document).ready(function() {
    $('#searchInput').keyup(function() {
        var searchText = $(this).val().toString().toLowerCase();

        $('tbody tr').each(function() {
            var name = $(this).data('name').toString().toLowerCase();
            var level = $(this).data('level').toString().toLowerCase();
            var institution = $(this).data('institution').toString().toLowerCase();
            var barangay = $(this).data('barangay').toString().toLowerCase();
            var street = $(this).data('street').toString().toLowerCase();
        

            if (
                name.includes(searchText) ||
                level.includes(searchText) ||
                institution.includes(searchText) ||
                barangay.includes(searchText) ||
                street.includes(searchText)
           
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
>>>>>>> b108fa4dc5d6b3645dcc7584571c79bf87a22615
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tableexport/5.2.0/tableexport.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>


    <!-- jQuery -->
    <script src="./assets/js/jquery-3.2.1.min.js"></script>
    <script src="./assets/js/print.js"></script>

    <!-- Bootstrap Core JS -->
    <script src="./assets/js/popper.min.js"></script>
    <script src="./assets/js/bootstrap.min.js"></script>

    <!-- Slimscroll JS -->
    <script src="./assets/js/jquery.slimscroll.min.js"></script>

    <!-- Select2 JS -->
    <script src="./assets/js/select2.min.js"></script>

    <!-- Datetimepicker JS -->
    <script src="./assets/js/moment.min.js"></script>
    <script src="./assets/js/bootstrap-datetimepicker.min.js"></script>

    <!-- Datatable JS -->
    <script src="./assets/js/jquery.dataTables.min.js"></script>
    <script src="./assets/js/dataTables.bootstrap4.min.js"></script>

    <!-- Custom JS -->
    <script src="./assets/js/app.js"></script>

    <script>
    function addHospital(success) {
        Swal.fire({
            title: 'Success!',
            text: success,
            icon: 'success',
            confirmButtonText: 'OK'
        });
    }

<<<<<<< HEAD

    document.addEventListener('DOMContentLoaded', function() {
=======
    
    document.addEventListener('DOMContentLoaded', function () {
>>>>>>> b108fa4dc5d6b3645dcc7584571c79bf87a22615
        <?php
        if (isset($_SESSION['add-hospital'])) {
            $success = $_SESSION['add-hospital'];
            // Clear the session variable
            unset($_SESSION['add-hospital']);

            // Call the function to display success message
            echo "addHospital('$success');";
        }
        ?>

<<<<<<< HEAD

    });
    </script>
=======
       
    });
</script>
>>>>>>> b108fa4dc5d6b3645dcc7584571c79bf87a22615

</body>

</html>