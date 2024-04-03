<?php

include('../includes/config.php');

session_start();
error_reporting(0);

//SESSION FOR REPO_USER_ID (NEEDED FOR EVERY FILE)
if (!isset($_SESSION['repo_user_id']) || empty($_SESSION['repo_user_id'])) {
    header("Location: login.php");
    exit; 
}
// Initializing ng hospital_name para sa banner
$hospital_name = $_SESSION['hospital_name'];




// Ang function ng code na to is to Fetch submitter information from the database
$sql = "SELECT user_fname, user_lname, user_mname, position FROM repo_user WHERE repo_user_id = $1";
$result = pg_query_params($db_connection, $sql, [$_SESSION['repo_user_id']]);

//fetching the user sa database
$row = pg_fetch_assoc($result);
if ($row) {
    //variables na needed para sa auto fetching and ilagay doon sa form
    $first_name = $row['user_fname'];
    $last_name = $row['user_lname'];
    $middle_name = $row['user_mname'];  
    $designation = $row['position'];
} else {
}


pg_close($db_connection);
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">

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

    .form-group {
        margin-bottom: 3.5rem;
    }

    .form-step {
        display: none;
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

    textarea.form-control {
        height: 180px;
    }

    .custom-label {
        color: #204A3D;
        font-weight: 500;
    }
        /* Hide the spinner for number input */
        input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    input[type=number] {
        -moz-appearance: textfield; /* Firefox */
    }
    .page-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.containers {
    background-color: #fff;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    max-width: 500px;
    padding: 20px;
}

    </style>
</head>

<body>
    <!-- Main Wrapper -->
    <div class="main-wrapper">

        <?php include("user-header.php"); ?>
        <?php include("user-sidebar.php"); ?>
        <div class="page-wrapper">
            <div class="containers">
            <form id="fileUploadForm" method="post" enctype="multipart/form-data" action="file-insertion-save.php">
                <input type="hidden" name="action" value="file-insertion-save.php" required="true">
                <input type="file" name="fileToUpload" id="fileToUpload" required="true" accept=".xls, .xlsx, .txt, .csv, .tsv, .json, .xml">
                <input type="submit" value="Upload File" class="btn btn-primary">
            </form>
            </div>
        </div>
    </div>

    <!-- Include SweetAlert library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@latest"></script>
    <script>
    //Function ng alert na 'to is if si user nag insert ng file v-validate yung ng file-insertion-save then kapag success
    //yung result gagawa yon ng $session="success" then redirect dito sa file-insertion.php then titignan ng script na 'to
    //kung may $session="success" s'ya if meron, mag a-alert sya ng insertion sucess      
    document.addEventListener('DOMContentLoaded', function() {
        <?php
        if (isset($_SESSION['insertion_success'])) {
            if ($_SESSION['insertion_success']) {
                // Display success alert
                echo "displaySuccessCredentialsAlert();";
            } else {
                // Display error alert
                echo "displayErrorAlert();";
            }

            // Clear the session variable
            unset($_SESSION['insertion_success']);
        }
        ?>

        function displaySuccessCredentialsAlert() {
            Swal.fire({
                title: 'Success!',
                text: 'Data inserted successfully.',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        }
//Ito naman pag false yung session succesful
        function displayErrorAlert() {
            Swal.fire({
                title: 'Error!',
                text: 'Failed to insert data.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    });
//--------end function---------//
</script>





    <script src="../assets/js/script.js"></script>
    <!-- jQuery -->
    <script src="../assets/js/jquery-3.2.1.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js">
    </script>
    <script>
    $(document).ready(function() {
        // Initialize first datepicker
        $("#datepicker1").datepicker();
        // Initialize second datepicker
        $("#datepicker2").datepicker();
        // Initialize third datepicker
        $("#datepicker3").datepicker();
        // Initialize fourth datepicker 
        $("#datepicker4").datepicker();
        // Initialize fifth datepicker
        $("#datepicker5").datepicker();




    });
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