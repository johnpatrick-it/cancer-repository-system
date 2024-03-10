<<<<<<< HEAD
<?php
session_start();

if (!isset($_SESSION['repo_user_id']) || empty($_SESSION['repo_user_id'])) {
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
    <link rel="shortcut icon" type="image/x-icon" href="./assets/img/pcc-logo.svg">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="./assets/css/font-awesome.min.css">

    <!-- Lineawesome CSS -->
    <link rel="stylesheet" href="./assets/css/line-awesome.min.css">

    <!-- Datatable CSS -->
    <link rel="stylesheet" href="./assets/css/dataTables.bootstrap4.min.css">

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="./assets/css/select2.min.css">

    <!-- Datetimepicker CSS -->
    <link rel="stylesheet" href="./assets/css/bootstrap-datetimepicker.min.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="./assets/css/style.css">

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

        <?php include("./includes/user-header.php"); ?>
        <?php include("./includes/user-sidebar.php"); ?>

        <div class="page-wrapper">
            <div class="content container-fluid">
                <div class="body-container">

                    <!-- HEADER -->
                    <div class="page-header">
                        <div class="row align-items-center">

                        </div>
                    </div>

                    <!-- SEARCH -->
                    <div class="row">
                        <div class="col-md-3">
                            <div class="col">
                                <h1 class="page-title">Manage Patients</h1>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <!-- Empty Space -->
                        </div>

                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6 ml-auto m-right">
                                    <div class="search-container ">
                                        <i class="fa fa-search"></i>
                                        <input type="text" id="searchInput" class="form-control pl-5 search-input"
                                            placeholder="Search">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="">
                                        <button class="btn filter-btn">
                                            <i class="fa fa-filter"></i> Filter
                                        </button>
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
                                            <th>Name</th>
                                            <th>Surname</th>
                                            <th>Hospital</th>
                                            <th>Type of Cancer</th>
                                            <th>Cancer Stage</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        //FUNCTION NG CODE NA TO IS:
                                        //KUKUHAIN NYA KUNG ANONG HOSPITAL NI CURRENT REPO_USER LOGIN SESSION
                                        //THEN I S-SAVE YUNG HOSPITAL-ID
                                        //THEN I QUERY KUNG ANONG PATIENT IS YUNG EQUAL DOON SA HOSPITAL-ID NA YON AT AYON YUNG I D-DISPLAY SA TABLE
                                        if (!$db_connection) {
                                            echo "Failed to connect to the database.";
                                        } else {
                                            $repo_user_id = $_SESSION['repo_user_id'];
                                            //QUERY PARA SA HOSPITAL ID THE I S-SAVE AS $HOSPITAL_ID
                                            $query_affiliation = "SELECT hospital_id FROM repo_user WHERE repo_user_id = '$repo_user_id'";
                                            $result_affiliation = pg_query($db_connection, $query_affiliation);

                                            if (!$result_affiliation) {
                                                echo "Error in query_affiliation: " . pg_last_error($db_connection);
                                                exit;
                                            }

                                            $row_affiliation = pg_fetch_assoc($result_affiliation);

                                            $hospital_id = $row_affiliation['hospital_id'];

                                            // PUTANG INANG SQL JOIN TO PUTANG INA MO
                                            $query = "SELECT
                                                        pgi.patient_last_name AS name,
                                                        pgi.patient_first_name AS surname,
                                                        hgi.hospital_name AS hospital,
                                                        pci.primary_site AS type_of_cancer,
                                                        pci.cancer_stage,
                                                        pci.patient_status AS status,
                                                        pgi.patient_id 
                                                    FROM
                                                        patient_general_info pgi
                                                    JOIN
                                                        hospital_general_information hgi ON pgi.hospital_id = hgi.hospital_id
                                                    JOIN
                                                        patient_cancer_info pci ON pgi.patient_id = pci.patient_id
                                                    WHERE
                                                        pgi.hospital_id = '$hospital_id'";
                                                        
                                            $result = pg_query($db_connection, $query);

                                            if (!$result) {
                                                echo "Error in query: " . pg_last_error($db_connection);
                                                exit;
                                            }
                                            //TABLE DISPLAY
                                            while ($row = pg_fetch_assoc($result)) {
                                                echo "<tr data-type='{$row['type_of_cancer']}' data-lastname='{$row['surname']}' data-firstname='{$row['name']}' data-hospital='{$row['hospital']}' data-cancer='{$row['type_of_cancer']}' data-stage='{$row['cancer_stage']}' data-status='{$row['status']}'>";
                                                echo "<td>" . $row['name'] . "</td>";
                                                echo "<td>" . $row['surname'] . "</td>";
                                                echo "<td>" . $row['hospital'] . "</td>";
                                                echo "<td>" . $row['type_of_cancer'] . "</td>";
                                                echo "<td>" . $row['cancer_stage'] . "</td>";
                                                echo "<td>" . $row['status'] . "</td>";
                                                echo "<td>
                                                <a href='patient-form-edit.php?edit={$row['patient_id']}' class='btn text-xs text-white btn-blue action-icon'><i class='fa fa-pencil'></i></a>
                                            </td>";
                                            


                                                echo "</tr>";
                                            }
                                            
                                            

                                            echo "</tbody>";
                                        }

                                        pg_close($db_connection);
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
    $(document).ready(function() {
        $('#searchInput').keyup(function() {
            var searchText = $(this).val().toLowerCase();

            $('tbody tr').each(function() {
                var name = $(this).data('firstname').toLowerCase();
                var surname = $(this).data('lastname').toLowerCase();
                var hospital = $(this).data('hospital').toLowerCase();
                var typeOfCancer = $(this).data('cancer').toLowerCase();
                var cancerStage = $(this).data('stage').toLowerCase();
                var status = $(this).data('status').toLowerCase();

                if (
                    name.includes(searchText) ||
                    surname.includes(searchText) ||
                    hospital.includes(searchText) ||
                    typeOfCancer.includes(searchText) ||
                    cancerStage.includes(searchText) ||
                    status.includes(searchText)
                ) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
    });
    </script>



    <!-- jQuery -->
    <script src="./assets/js/jquery-3.2.1.min.js"></script>

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
</body>

=======
<?php
session_start();

if (!isset($_SESSION['repo_user_id']) || empty($_SESSION['repo_user_id'])) {
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
    <link rel="shortcut icon" type="image/x-icon" href="./assets/img/pcc-logo.svg">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="./assets/css/font-awesome.min.css">

    <!-- Lineawesome CSS -->
    <link rel="stylesheet" href="./assets/css/line-awesome.min.css">

    <!-- Datatable CSS -->
    <link rel="stylesheet" href="./assets/css/dataTables.bootstrap4.min.css">

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="./assets/css/select2.min.css">

    <!-- Datetimepicker CSS -->
    <link rel="stylesheet" href="./assets/css/bootstrap-datetimepicker.min.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="./assets/css/style.css">

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

        <?php include("./includes/user-header.php"); ?>
        <?php include("./includes/user-sidebar.php"); ?>

        <div class="page-wrapper">
            <div class="content container-fluid">
                <div class="body-container">

                    <!-- HEADER -->
                    <div class="page-header">
                        <div class="row align-items-center">

                        </div>
                    </div>

                    <!-- SEARCH -->
                    <div class="row">
                        <div class="col-md-3">
                            <div class="col">
                                <h1 class="page-title">Manage Patients</h1>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <!-- Empty Space -->
                        </div>

                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6 ml-auto m-right">
                                    <div class="search-container ">
                                        <i class="fa fa-search"></i>
                                        <input type="text" id="searchInput" class="form-control pl-5 search-input"
                                            placeholder="Search">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="">
                                        <button class="btn filter-btn">
                                            <i class="fa fa-filter"></i> Filter
                                        </button>
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
                                            <th>Name</th>
                                            <th>Surname</th>
                                            <th>Hospital</th>
                                            <th>Type of Cancer</th>
                                            <th>Cancer Stage</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        //FUNCTION NG CODE NA TO IS:
                                        //KUKUHAIN NYA KUNG ANONG HOSPITAL NI CURRENT REPO_USER LOGIN SESSION
                                        //THEN I S-SAVE YUNG HOSPITAL-ID
                                        //THEN I QUERY KUNG ANONG PATIENT IS YUNG EQUAL DOON SA HOSPITAL-ID NA YON AT AYON YUNG I D-DISPLAY SA TABLE
                                        if (!$db_connection) {
                                            echo "Failed to connect to the database.";
                                        } else {
                                            $repo_user_id = $_SESSION['repo_user_id'];
                                            //QUERY PARA SA HOSPITAL ID THE I S-SAVE AS $HOSPITAL_ID
                                            $query_affiliation = "SELECT hospital_id FROM repo_user WHERE repo_user_id = '$repo_user_id'";
                                            $result_affiliation = pg_query($db_connection, $query_affiliation);

                                            if (!$result_affiliation) {
                                                echo "Error in query_affiliation: " . pg_last_error($db_connection);
                                                exit;
                                            }

                                            $row_affiliation = pg_fetch_assoc($result_affiliation);

                                            $hospital_id = $row_affiliation['hospital_id'];

                                            // PUTANG INANG SQL JOIN TO PUTANG INA MO
                                            $query = "SELECT
                                                        pgi.patient_last_name AS name,
                                                        pgi.patient_first_name AS surname,
                                                        hgi.hospital_name AS hospital,
                                                        pci.primary_site AS type_of_cancer,
                                                        pci.cancer_stage,
                                                        pci.patient_status AS status,
                                                        pgi.patient_id 
                                                    FROM
                                                        patient_general_info pgi
                                                    JOIN
                                                        hospital_general_information hgi ON pgi.hospital_id = hgi.hospital_id
                                                    JOIN
                                                        patient_cancer_info pci ON pgi.patient_id = pci.patient_id
                                                    WHERE
                                                        pgi.hospital_id = '$hospital_id'";
                                                        
                                            $result = pg_query($db_connection, $query);

                                            if (!$result) {
                                                echo "Error in query: " . pg_last_error($db_connection);
                                                exit;
                                            }
                                            //TABLE DISPLAY
                                            while ($row = pg_fetch_assoc($result)) {
                                                echo "<tr data-type='{$row['type_of_cancer']}' data-lastname='{$row['surname']}' data-firstname='{$row['name']}' data-hospital='{$row['hospital']}' data-cancer='{$row['type_of_cancer']}' data-stage='{$row['cancer_stage']}' data-status='{$row['status']}'>";
                                                echo "<td>" . $row['name'] . "</td>";
                                                echo "<td>" . $row['surname'] . "</td>";
                                                echo "<td>" . $row['hospital'] . "</td>";
                                                echo "<td>" . $row['type_of_cancer'] . "</td>";
                                                echo "<td>" . $row['cancer_stage'] . "</td>";
                                                echo "<td>" . $row['status'] . "</td>";
                                                echo "<td>
                                                <a href='patient-form-edit.php?edit={$row['patient_id']}' class='btn text-xs text-white btn-blue action-icon'><i class='fa fa-pencil'></i></a>
                                            </td>";
                                            


                                                echo "</tr>";
                                            }
                                            
                                            

                                            echo "</tbody>";
                                        }

                                        pg_close($db_connection);
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
    $(document).ready(function() {
        $('#searchInput').keyup(function() {
            var searchText = $(this).val().toLowerCase();

            $('tbody tr').each(function() {
                var name = $(this).data('firstname').toLowerCase();
                var surname = $(this).data('lastname').toLowerCase();
                var hospital = $(this).data('hospital').toLowerCase();
                var typeOfCancer = $(this).data('cancer').toLowerCase();
                var cancerStage = $(this).data('stage').toLowerCase();
                var status = $(this).data('status').toLowerCase();

                if (
                    name.includes(searchText) ||
                    surname.includes(searchText) ||
                    hospital.includes(searchText) ||
                    typeOfCancer.includes(searchText) ||
                    cancerStage.includes(searchText) ||
                    status.includes(searchText)
                ) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
    });
    </script>



    <!-- jQuery -->
    <script src="./assets/js/jquery-3.2.1.min.js"></script>

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
</body>

>>>>>>> b108fa4dc5d6b3645dcc7584571c79bf87a22615
</html>