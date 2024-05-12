<?php
session_start();

//VERY IMPORTANT DONT ERASE
if (!isset($_SESSION['admin_id']) || empty($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;   
}


error_reporting(0);
include('includes/config.php');


require('fpdf186/fpdf.php'); // Include the FPDF library

// Check if the button is clicked
if (isset($_POST['generate_pdf']) && isset($_SESSION['selected_region'])) {
    // Fetch data from the database (replace with your actual database connection code)
    $Region = $_SESSION['selected_region'];
    $query = "SELECT * FROM patient_data WHERE address_region = '$Region'";
    $result = pg_query($db_connection, $query);

    // Check if query was successful
    if ($result) {
        // Initialize PDF
        $pdf = new FPDF();
        $pdf->AddPage();

        // Set font
        $pdf->SetFont('Arial','B',16);

        // Add a title
      $pdf->Cell(0, 10, 'Patient Data for ' . $Region, 0, 1, 'C');


        // Add column headers
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(20,10,'Patient ID',1,0,'C');
        $pdf->Cell(40,10,'Patient Name',1,0,'C');
        $pdf->Cell(30,10,'Address Region',1,0,'C');
        $pdf->Cell(22,10,'Primary Site',1,0,'C');
        $pdf->Cell(22,10,'Cancer Stage',1,0,'C');
        $pdf->Cell(30,10,'Patient Treatment',1,0,'C');
        $pdf->Cell(22,10,'Patient Status',1,1,'C');

        // Set font for data
        $pdf->SetFont('Arial','',8);

        // Fetch data and add to PDF
        while ($row = pg_fetch_assoc($result)) {
          
            $pdf->Cell(20,10,$row['patient_id'],1,0,'C');
            $pdf->Cell(40,10,$row['patient_name'],1,0,'C');
            $pdf->Cell(30,10,$row['address_region'],1,0,'C');
            $pdf->Cell(22,10,$row['primary_site'],1,0,'C');
            $pdf->Cell(22,10,$row['cancer_stage'],1,0,'C');
            $pdf->Cell(30,10,$row['patient_treatment'],1,0,'C');
            $pdf->Cell(22,10,$row['patient_status'],1,1,'C');
        }

        // Output PDF content
        $pdf->Output('D', 'patient_data.pdf'); // 'D' option forces download
        exit;
    } else {
        // Handle query error
        echo "Error: " . pg_last_error($db_connection);
    }
}

if (isset($_POST['generate_csv']) && isset($_SESSION['selected_region'])) {
    // Fetch data from the database (replace with your actual database connection code)
    $Region = $_SESSION['selected_region'];
    $query = "SELECT patient_id, patient_name, address_region, primary_site, cancer_stage, patient_treatment, patient_status FROM patient_data WHERE address_region = '$Region'";
    $result = pg_query($db_connection, $query);

    // Check if query was successful
    if ($result) {
        // Initialize CSV content with column headers
        $csv_content = "Patient ID, Patient Name, Address Region, Primary Site, Cancer Stage, Patient Treatment, Patient Status\n";

        // Fetch all rows and append to CSV content
        while ($row = pg_fetch_assoc($result)) {
            // Append row data to CSV content
            $csv_content .= "{$row['patient_id']}, {$row['patient_name']}, {$row['address_region']}, {$row['primary_site']}, {$row['cancer_stage']}, {$row['patient_treatment']}, {$row['patient_status']}\n";
        }

        // Set headers for CSV download
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="patient_data.csv"');

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

    <!-- Sweetalert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@latest/dist/sweetalert2.min.css">

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
                                <h3 class="page-title">Patient Data</h3>
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
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                    <div class="col-auto">
                                        <div class="dropdown">
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
                                        </div>
                                    </div>
                                </form>
                        </div>

                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-auto ml-auto m-right">
                                    <form method="post" action="">

                                        <select name="region" class="form-control" id="region">
                                            <option value="">Select Region</option>
                                            <option value="BARMM">BARMM</option>
                                            <option value="Bangsamoro">Bangsamoro</option>
                                            <option value="Bicol Region">Bicol Region</option>
                                            <option value="CAR">CAR</option>
                                            <option value="Cagayan Valley">Cagayan Valley</option>
                                            <option value="Calabarzon">Calabarzon</option>
                                            <option value="Caraga">Caraga</option>
                                            <option value="Central Luzon">Central Luzon</option>
                                            <option value="Central Visayas">Central Visayas</option>
                                            <option value="Cordillera Administrative Region">Cordillera Administrative
                                                Region</option>
                                            <option value="Davao Region">Davao Region</option>
                                            <option value="Eastern Visayas">Eastern Visayas</option>
                                            <option value="Ilocos Region">Ilocos Region</option>
                                            <option value="Mimaropa Region">Mimaropa Region</option>
                                            <option value="NCR">NCR</option>
                                            <option value="National Capital Region">National Capital Region</option>
                                            <option value="Northern Mindanao">Northern Mindanao</option>
                                            <option value="Soccsksargen">Soccsksargen</option>
                                            <option value="Southwestern Tagalog Region">Southwestern Tagalog Region
                                            </option>
                                            <option value="Western Visayas">Western Visayas</option>
                                            <option value="Zamboanga Peninsula">Zamboanga Peninsula</option>
                                            <option value="mimaropa">mimaropa</option>
                                            <option value="regionI">regionI</option>
                                            <option value="regionII">regionII</option>
                                            <option value="regionIII">regionIII</option>
                                            <option value="regionIV-A">regionIV-A</option>
                                            <option value="regionIX">regionIX</option>
                                            <option value="regionV">regionV</option>
                                            <option value="regionVI">regionVI</option>
                                            <option value="regionVII">regionVII</option>
                                            <option value="regionVIII">regionVIII</option>
                                            <option value="regionX">regionX</option>
                                            <option value="regionXI">regionXI</option>
                                            <option value="regionXII">regionXII</option>
                                            <option value="regionXIII">regionXIII</option>


                                            <!-- Add more options as needed -->
                                        </select>

                                </div>
                                <div class="col-auto">
                                    <input type="submit" name="submit" class="add-btn" value="Fetch Data">
                                    </form>
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
                                            <th>Case ID</th>
                                            <th>Sex</th>
                                            <th>Address Region</th>
                                            <th>Cancer Type</th>
                                            <th>Cancer Stage</th>
                                            <th>Treatment</th>
                                            <th>Status</th>
                                            </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                       
                       if (!$db_connection) {
                           echo "Failed to connect to the database.";
                       } else {
                           // Check if the form is submitted
                           if(isset($_POST['submit']) && isset($_POST['region'])) {
                               // Get the selected region
                               $selectedRegion = $_POST['region'];
                               $_SESSION['selected_region'] = $selectedRegion;
                               // Construct the query with a placeholder for the parameter
                               $query = "SELECT * FROM patient_data WHERE address_region = '$selectedRegion'";
                       
                               // Execute the query
                               $result = pg_query($db_connection, $query);
                       
                               // Check if query execution is successful
                               if ($result) {
                                   // Fetch the results
                                   while ($row = pg_fetch_assoc($result)) {
                                       echo "<tr>";
                                       echo "<td class=''>" . $row['patient_id'] . "</td>";
                                       echo "<td class=''>" . $row['sex'] . "</td>";
                                       echo "<td class='region'>" . $row['address_region'] . "</td>";
                                       echo "<td class=''>" . $row['primary_site'] . "</td>";
                                       echo "<td class='stage'>" . $row['cancer_stage'] . "</td>";
                                       echo "<td class=''>" . $row['patient_treatment'] . "</td>";
                                       echo "<td class=''>" . $row['patient_status'] . "</td>";
                                       echo "<td>";
                                       // Add action buttons if needed
                                       echo "</td>";
                                       echo "</tr>";
                                   }
                               } else {
                                   echo "Error executing query: " . pg_last_error($db_connection);
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




            <!-- Edit Hospital Modal -->
            <?php include_once 'includes/modals/hospital/edit_user.php'; ?>

            <!-- Delete Hospital Modal -->
            <?php include_once 'includes/modals/hospital/delete_user.php'; ?>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#searchInput').keyup(function() {
            var searchText = $(this).val().toString().toLowerCase();

            $('tbody tr').each(function() {
                var regionName = $(this).find('.region').text().toLowerCase();
                var cancerStage = $(this).find('.stage').text().toLowerCase();
                var lastName = $(this).find('.last-name').text().toLowerCase();
                var hospitalAffiliated = $(this).find('.hospital-affiliated').text()
                    .toLowerCase();
                var userPosition = $(this).find('.user-position').text().toLowerCase();

                if (
                    regionName.includes(searchText) ||
                    cancerStage.includes(searchText) ||
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

    function selectRegion(region) {
        console.log('Selected Region:', region); // Debugging statement
        // Set the selected region value to the hidden input field
        document.getElementById('selectedRegion').value = region;
        // Submit the form to fetch the data
        document.getElementById('fetchDataForm').submit();
    }
    </script>
    <!-- Include the necessary libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.min.js"></script>

    <!-- JavaScript code to export table to PDF -->
    <script>
    function exportTableToPDF() {
        // Get the table element
        var table = document.getElementById("imformationTable");

        // Create a new jsPDF instance
        var pdf = new jsPDF('p', 'pt', 'a4');

        // Options for html2canvas
        var options = {
            scale: 2, // Increase scale to improve quality
            useCORS: true, // Allow cross-origin requests
            scrollY: 0, // Start capturing from the top
            logging: true // Enable logging to debug any issues
        };

        // Use html2canvas to capture the table as an image
        html2canvas(table, options).then(function(canvas) {
            var imgData = canvas.toDataURL('image/png');

            // Calculate dimensions of the PDF page
            var imgWidth = pdf.internal.pageSize.getWidth();
            var imgHeight = (canvas.height * imgWidth) / canvas.width;

            // Add image to the PDF
            pdf.addImage(imgData, 'PNG', 0, 0, imgWidth, imgHeight);

            // Save the PDF file
            pdf.save("information_data.pdf");
        });
    }
    </script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tableexport/5.2.0/tableexport.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>



    <!-- jQuery -->
    <script src="assets/js/jquery-3.2.1.min.js"></script>
    <script src="assets/js/print.js"></script>

    <!-- Bootstrap Core JS -->
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

    <!-- Slimscroll JS -->
    <script src="assets/js/jquery.slimscroll.min.js"></script>

    <!-- Chart JS -->
    <script src="assets/js/chart.js"></script>

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