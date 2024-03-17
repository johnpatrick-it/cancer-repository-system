<?php
session_start();

//VERY IMPORTANT DONT ERASE
if (!isset($_SESSION['admin_id']) || empty($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit; 
}

$AdminID = $_SESSION['admin_id'] ?? '';

include('includes/config.php');

$host = "user=postgres.tcfwwoixwmnbwfnzchbn password=sbit4e-4thyear-capstone-2023 host=aws-0-ap-southeast-1.pooler.supabase.com port=5432 dbname=postgres";
                                            
try {
    $dbh = new PDO("pgsql:" . $host);
    
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}


?>

<?php



// Establish database connection (replace with your credentials)


if (isset($_POST['add'])) {
    $equipment_name = trim($_POST['equipment_name']);  // Trim whitespace for security
    $description = trim($_POST['description']);
    $admin_user_id = $AdminID;  // Assuming you've set $AdminID elsewhere

    if (isset($_FILES['image'])) {
        if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
            // Validate image file type and size (replace with your allowed extensions)
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (in_array($_FILES['image']['type'], $allowedTypes) && $_FILES['image']['size'] <= 2097152) { // 2MB limit
                $tmp_name = $_FILES['image']['tmp_name'];
                $image_data = file_get_contents($tmp_name);
            } else {
                $_SESSION['error'] = "Invalid image format or size.";
                header("location: equipment-category.php");
                exit;
            }
        } else {
            $_SESSION['error'] = "Error uploading file.";
            header("location: equipment-category.php");
            exit;
        }
    } else {
        $_SESSION['error'] = "Please select an image to upload.";
        header("location: equipment-category.php");
        exit;
    }

    // Check for existing equipment category
    $check_stmt = $dbh->prepare("SELECT * FROM repo_equipment_category WHERE equipment_name = :equipment_name");
    $check_stmt->bindParam(':equipment_name', $equipment_name);
    $check_stmt->execute();

    if ($check_stmt->rowCount() > 0) {
        $_SESSION['already-exist'] = "Equipment Already Exist";
        header("location: equipment-category.php");
        exit;
    } else {
        // Insert new category
        $created_at = date("Y-m-d H:i:s");
        $insert_stmt = $dbh->prepare("INSERT INTO repo_equipment_category (equipment_name, description, created_at, admin_user_id, image_data) VALUES (:equipment_name, :description, :created_at, :admin_user_id, :image_data)");
        $insert_stmt->bindParam(':equipment_name', $equipment_name);
        $insert_stmt->bindParam(':description', $description);
        $insert_stmt->bindParam(':created_at', $created_at);
        $insert_stmt->bindParam(':admin_user_id', $admin_user_id);
        $insert_stmt->bindParam(':image_data', $image_data, PDO::PARAM_LOB);

        if ($insert_stmt->execute()) {
            $_SESSION['success'] = "Equipment added Successfully";
        } else {
            $_SESSION['error'] = "Failed to add equipment";
        }

        header("location: equipment-category.php");
        exit;
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

    .card-box,
    .da-card {
        background-color: #fff;
        border-radius: 10px;
        -webkit-box-shadow: 0 0 28px rgba(0, 0, 0, 0.08);
        box-shadow: 0 0 28px rgba(0, 0, 0, 0.08);
    }

    .pd-30 {
        padding: 30px;
    }

    .description-cell {
        max-width: 200px;

        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        word-wrap: break-word;

    }

    .equipment-image {
        border-radius: 50%;
        width: 30px;
        height: 30px;
        border: 1px solid black;

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
                                <h3 class="page-title">Equipment Category</h3>
                            </div>
                        </div>
                    </div>

                    <!-- SEARCH -->
                    <div class="row">
                        <div class="col-md-3">
                            <div class="search-container">
                                <i class="fa fa-search"></i>
                                <input type="text" class="form-control pl-5 search-input" placeholder="Search"
                                    id="searchInput">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <!-- Empty Space -->
                        </div>

                        <div class="col-md-6">



                            <div class="row justify-content-end">
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
                        <div class="col-lg-4 col-md-6 col-sm-12 mb-30">
                            <div class="card-box pd-30 pt-10 height-100-p">
                                <h2 class="mb-30 h4">New Equipment Category</h2>
                                <section>
                                    <form name="save" method="post" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Equipment Name</label>
                                                    <input name="equipment_name" type="text" class="form-control"
                                                        required="true" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Description</label>
                                                    <textarea id="textarea1" name="description" class="form-control"
                                                        required length="150" maxlength="150" required="true"
                                                        autocomplete="off"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Image</label>
                                                    <input name="image" type="file" class="form-control" required="true"
                                                        autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 text-right">
                                            <div class="dropdown">
                                                <input class="btn btn-primary" type="submit" value="Save" name="add"
                                                    id="add">
                                            </div>
                                        </div>
                                    </form>
                                </section>
                            </div>
                        </div>

                        <div class="col-lg-8 col-md-6 col-sm-12 mb-30">
                            <div class="card-box pd-30 pt-10 height-100-p">
                                <h2 class="mb-30 h4">Euipment List</h2>
                                <div class="pb-20">
                                    <table class="data-table table stripe hover nowrap" id="imformationTable">
                                        <thead>
                                            <tr>
                                                <th class="searchable">ID.</th>
                                                <th class="searchable">IMG</th>
                                                <th class="searchable">CATEGORY NAME</th>
                                                <th class="searchable">DESCRIPTION</th>
                                                <th class="searchable">DATE CREATED</th>
                                                <th>ACTION</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
    // Your database connection details
    $host = "host=aws-0-ap-southeast-1.pooler.supabase.com port=5432 dbname=postgres user=postgres.tcfwwoixwmnbwfnzchbn password=sbit4e-4thyear-capstone-2023";

    try {
        // Create a new PDO instance
        $dbh = new PDO("pgsql:" . $host);
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        exit; // Stop execution if unable to connect to the database
    }

    $query = "SELECT * FROM repo_equipment_category";
    $stmt = $dbh->prepare($query);
    $stmt->execute();

    // Fetch all results
    $results = $stmt->fetchAll(PDO::FETCH_OBJ);

    // Check if any images are found
    if ($results) {
        $cnt = 1;
        // Display the images within a table
        foreach ($results as $result) {
            // Get the image data
            $imageData = $result->image_data;

            // Check if image data is empty or null
            if ($imageData) {
                // Convert the image data to base64 encoding
                $base64Image = base64_encode(stream_get_contents($imageData));

                // Display the image within a table row
                echo '<tr>';
                echo '<td>' . htmlentities($cnt) . '</td>';
                echo '<td><img src="data:image/jpeg;base64,' . $base64Image . '" alt="Equipment Image" class="equipment-image"></td>';
                echo '<td>' . htmlentities($result->equipment_name) . '</td>';
                echo '<td class="description-cell">' . htmlentities($result->description) . '</td>';
                echo '<td>' . htmlentities(date('Y-m-d', strtotime($result->created_at))) . '</td>';
                echo '<td>';
                echo '<a href="#" data-toggle="modal" data-target="#edit_equipment" title="Edit" class="btn text-xs text-white btn-blue action-icon"><i class="fa fa-pencil"></i></a>';
                echo '<a href="#" data-toggle="modal" data-target="#delete_hospital" title="Delete" class="btn text-xs text-white btn-danger action-icon ml-2"><i class="fa fa-trash"></i></a>';
                echo '</td>';
                echo '</tr>';
                $cnt++;
            } else {
                echo "<tr><td colspan='6'>Image data is empty or null.</td></tr>";
            }
        }
    } else {
        echo "<tr><td colspan='6'>No images found.</td></tr>";
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

            <!-- Add User Modal -->
            <?php include_once 'includes/modals/hospital/add_user.php'; ?>

            <!-- Edit Hospital Modal -->
            <?php include_once 'includes/modals/hospital/edit_equipment.php'; ?>


        </div>
    </div>



    <!-- Include SweetAlert library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@latest"></script>
    <script>
    function successEquipment(Success) {
        Swal.fire({
            title: 'Success!',
            text: 'Equipment Added Successfully',
            icon: 'success',
            confirmButtonText: 'OK'
        });
    }

    function AlreadyExist(Error) {
        Swal.fire({
            title: 'Error!',
            text: 'Equipment Already Exist',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    }


    document.addEventListener('DOMContentLoaded', function() {
        <?php
            if (isset($_SESSION['success'])) {
                $Success = $_SESSION['success'];
                // Clear the session error variable
                unset($_SESSION['success']);

                // Display the error for incorrect password
                echo "successEquipment('$Success');";
            }
            ?>

        <?php
            if (isset($_SESSION['already-exist'])) {
                $Error = $_SESSION['already-exist'];
                // Clear the session error variable
                unset($_SESSION['already-exist']);

                // Display the error for incorrect password
                echo "AlreadyExist('$Error');";
            }
            ?>
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
    <script src="./assets/js/jquery-3.2.1.min.js"></script>
    <script src="./assets/js/print.js"></script>


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
    <script src="assets/js/app.js"></script>
</body>

</html>