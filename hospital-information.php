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
                                <h3 class="page-title">Hospital Information</h3>
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
                                    <button type="button" class="btn add-btn" data-toggle="modal" data-target="#firstModal"><i class="fa fa-medkit"></i>Add Hospital</button>
                                    <a href="#" id="hidebtn" class="add-btn" data-toggle="modal" data-target="#add_hospital"></a>
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
                                            <th>Hospital Name</th>
                                            <th>Hospital Level</th>
                                            <th>Hospital Category</th>
                                            <th>Resource level</th>
                                            <th>Hospital Location UACS CODE</th>
                                            <th>Hospital Street</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Check if the database connection is successful
                                        if (!$db_connection) {
                                            echo "<tr><td colspan='7'>Failed to connect to the database.</td></tr>";
                                        } else {
                                            // Construct the query to retrieve hospital information along with equipment details
                                            $query = "SELECT h.hospital_id, h.hospital_name, h.hospital_level, h.type_of_institution, h.hospital_barangay, h.hospital_street, h.specialty, array_agg(e.equipment_name) AS equipments
                                                    FROM hospital_general_information h
                                                    LEFT JOIN hospital_equipment he ON h.hospital_id = he.hospital_id
                                                    LEFT JOIN repo_equipment_category e ON he.equipment_id = e.equipment_id
                                                    GROUP BY h.hospital_id, h.hospital_name, h.hospital_level, h.type_of_institution, h.hospital_barangay, h.hospital_street, h.specialty";

                                            // Execute the query
                                            $result = pg_query($db_connection, $query);

                                            // Check if query execution is successful
                                            if ($result) {
                                                // Fetch and display hospital information
                                                while ($row = pg_fetch_assoc($result)) {
                                                    echo "<tr>";
                                                    echo "<td>" . htmlspecialchars($row['hospital_name']) . "</td>";
                                                    echo "<td>" . htmlspecialchars($row['hospital_level']) . "</td>";
                                                    echo "<td>" . htmlspecialchars($row['type_of_institution']) . "</td>";
                                                    echo "<td>" . htmlspecialchars($row['specialty']) . "</td>";
                                                    echo "<td>" . htmlspecialchars($row['hospital_barangay']) . "</td>";
                                                    echo "<td>" . htmlspecialchars($row['hospital_street']) . "</td>";  
                                                    echo "<td>";
                                                    //echo "<a href='hospital-information-edit.php?hospital_id=" . htmlspecialchars($row['hospital_id']) . "' title='Edit' class='btn text-xs text-white btn-blue edit-action'><i class='fa fa-pencil'></i></a>";
                                                    echo "</td>";
                                                    echo "</tr>";
                                                }
                                            } else {
                                                echo "<tr><td colspan='7'>Failed to fetch hospital information.</td></tr>";
                                            }

                                            // Close the database connection
                                            pg_close($db_connection);
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>




            <!-- Add Hospital  Modal -->
            <?php include_once 'includes/modals/hospital/add_hospital.php'; ?>

            <!-- Edit Hospital Modal -->
            <?php include_once 'includes/modals/hospital/edit_hospital.php'; ?>


        </div>
    </div>

    <div id="firstModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Admin Login</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="adminLoginForm">
                        <div class="form-group">
                            <label for="Password">Password</label>
                            <input type="password" class="form-control" id="passwordInput" name="passwordInput" required
                                autocomplete="off">
                        </div>
                        <button type="button" class="btn btn-primary" id="adminLoginBtn">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Include SweetAlert2 CSS and JS files -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
    $(document).ready(function() {
        // Function to open the add_hospital modal
        function openAddHospitalModal() {
            $('#add_hospital').modal('show');
            console.log("Modal opened");
        }

        function closeFirstModal() {
            $('#firstModal').modal('hide');
        }

        $('#passwordInput').keypress(function(event) {
            if (event.keyCode === 13) {
                event.preventDefault();
                $('#adminLoginBtn').click();
            }
        });

        $('#adminLoginBtn').click(function() {
            var password = $('#passwordInput').val();

            $.ajax({
                type: "POST",
                url: "authenticate.php",
                data: {
                    password: password
                },
                success: function(response) {
                    if (response === "success") {
                        closeFirstModal();
                        $('.add-btn').trigger('click');
                        openAddHospitalModal();
                        setTimeout(function() {
                            console.log("Modal closed after 10 seconds");
                            // Display SweetAlert2 modal
                            Swal.fire({
                                icon: 'warning',
                                title: 'Session Expired',
                                text: 'Your session has expired. Redirecting to Hospital Information page...',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });
                        }, 120000);
                    } else if (response === "session_expired") {
                        Swal.fire({
                            icon: 'error',
                            title: 'Session Expired',
                            text: 'Your session has expired. Please log in again.'
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Authentication Failed',
                            text: 'Invalid password.'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Server Error',
                        text: 'There was an error processing your request. Please try again later.'
                    });
                }
            });
        });
    });
    </script>




    <!-- Include SweetAlert library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script>
$(document).ready(function() {
    $('#searchInput').keyup(function() {
        var searchText = $(this).val().toLowerCase();

        $('tbody tr').each(function() {
            var name = $(this).find('td:nth-child(1)').text().toLowerCase();
            var level = $(this).find('td:nth-child(2)').text().toLowerCase();
            var category = $(this).find('td:nth-child(3)').text().toLowerCase();
            var resourceLevel = $(this).find('td:nth-child(4)').text().toLowerCase();
            var locationCode = $(this).find('td:nth-child(5)').text().toLowerCase();
            var street = $(this).find('td:nth-child(6)').text().toLowerCase();

            if (
                name.includes(searchText) ||
                level.includes(searchText) ||
                category.includes(searchText) ||
                resourceLevel.includes(searchText) ||
                locationCode.includes(searchText) ||
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@latest"></script>

    <script>
    $(document).ready(function() {
        // Event listener for edit button click
        $('.edit-action').click(function() {
            // Get the hospital ID from the data attribute
            var hospitalId = $(this).data('hospital-id');

            // Store the hospital ID in the hidden input field
            $('#hospitalId').val(hospitalId);

            // Fetch hospital data using AJAX
            $.ajax({
                url: 'fetch_hospital.php', // URL to your PHP script to fetch hospital data
                method: 'POST',
                data: {
                    hospital_id: hospitalId
                },
                success: function(response) {
                    // Parse the JSON response
                    var hospitalData = JSON.parse(response);

                    // Populate the modal fields with the fetched data
                    $('#hospital_name').val(hospitalData.hospital_name);
                    $('#hospital_level').val(hospitalData.hospital_level);
                    $('#type_of_institution').val(hospitalData
                        .type_of_institution);
                    $('#specialty').val(hospitalData.specialty);
                    $('#hospital_barangay').val(hospitalData
                        .hospital_barangay);
                    $('#hospital_street').val(hospitalData.hospital_street);
                },
                error: function(xhr, status, error) {
                    // Handle error
                    console.error(error);
                }
            });
        });
    });
    </script>

    <?php
// Check if the session variable is set
if (isset($_SESSION['add-hospital'])) {
    // Display the alert message
    echo '<script>
        Swal.fire({
            title: "Success!",
            text: "' . $_SESSION['add-hospital'] . '",
            icon: "success",
            confirmButtonText: "OK"
        });
    </script>';
    
    // Unset the session variable to prevent displaying the message again on page refresh
    unset($_SESSION['add-hospital']);
}
?>
    <!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
$(document).ready(function() {
    $('#searchInput').keyup(function() {
        var searchText = $(this).val().toLowerCase();

        $('tbody tr').each(function() {
            var name = $(this).find('td:nth-child(1)').text().toLowerCase();
            var level = $(this).find('td:nth-child(2)').text().toLowerCase();
            var institution = $(this).find('td:nth-child(3)').text().toLowerCase();
            var barangay = $(this).find('td:nth-child(4)').text().toLowerCase();
            var street = $(this).find('td:nth-child(5)').text().toLowerCase();

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

    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.min.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tableexport/5.2.0/tableexport.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js">
    </script>

    <!-- jQuery -->
    <script src=" assets/js/jquery-3.2.1.min.js"></script>

    <!-- Bootstrap Core JS -->
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

    <!-- Slimscroll JS -->
    <script src="assets/js/jquery.slimscroll.min.js"></script>

    <!-- Select2 JS -->
    <script src="assets/js/select2.min.js"></script>

    <!-- Datetimepicker JS -->
    <script src="assets/js/moment.min.js"></script>
    <script src="assets/js/bootstrap-datetimepicker.min.js"></script>

    <!-- Datatable JS -->
    <script src="assets/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/dataTables.bootstrap4.min.js"></script>

    <!-- Custom JS -->
    <script src="assets/js/app.js"></script>\
    <script src="assets/js/print.js"></script>
</body>

</html>