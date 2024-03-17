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

if (isset($_POST['add'])) {
    $equipment_name = $_POST['equipment_name'];
    $description = $_POST['description'];
    $admin_user_id = $AdminID; // Assuming $session_id holds the admin's ID


    
     
    if (isset($_FILES['image'])) {
        $image = $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], './uploads/'.$image);
        $location = $image;
        
    } else {
        echo "No file uploaded or the 'image' key is not set in the \$_FILES array.";
    }
    
    // Check if the category already exists
    $check_stmt = $dbh->prepare("SELECT * FROM repo_equipment_category WHERE equipment_name = :equipment_name");
    $check_stmt->bindParam(':equipment_name', $equipment_name);
    $check_stmt->execute();
    $count = $check_stmt->rowCount();

    if ($count > 0) {
         // add error swal alert
            $_SESSION['already-exist'] = "Equipment Already Exist";
            header("location: equipment-category.php");
            exit;
    } else {
        // If the category doesn't exist, proceed with the insertion

        $created_at = date("Y-m-d H:i:s"); // Get the current date and time

       

        // Insert the new category
        $insert_stmt = $dbh->prepare("INSERT INTO repo_equipment_category (equipment_name, description, created_at, admin_user_id, image_data) VALUES (:equipment_name, :description, :created_at, :admin_user_id, :image_data)");
        $insert_stmt->bindParam(':equipment_name', $equipment_name);
        $insert_stmt->bindParam(':description', $description);
        $insert_stmt->bindParam(':created_at', $created_at);
        $insert_stmt->bindParam(':admin_user_id', $admin_user_id);
        $insert_stmt->bindParam(':image_data', $location); // Add this line
        

        if ($insert_stmt->execute()) {
        // add success swal alert
        $_SESSION['success'] = "Equipment added Successfully";
        header("location: equipment-category.php");
        exit;
        } else {
            // add error swal alert
            $_SESSION['already-exist'] = "Equipment Already Exist";
            header("location: equipment-category.php");
            exit;
        }
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
                                    
                                            $sql = "SELECT * from repo_equipment_category";
											$query = $dbh -> prepare($sql);
											$query->execute();
											$results=$query->fetchAll(PDO::FETCH_OBJ);
											$cnt=1;
											if($query->rowCount() > 0)
											{
											foreach($results as $result)
											{               ?>

                                            <tr>
                                                <td> <?php echo htmlentities($cnt);?></td>
                                                <td>
                                                    <?php
                                                // Assuming $result->location contains the image filename
                                                $imageFilename = htmlentities($result->image_data);
                                                $imagePath = "uploads/$imageFilename"; // Adjust the folder name if needed
                                            
                                                // Checking if the file exists before displaying it
                                                if (file_exists($imagePath)) {
                                                    echo "<img src=\"$imagePath\" alt=\"Image\" style=\"border-radius: 50%; width: 30px; height: 30px; border: 1px solid black;\">";
                                                } else {
                                                    echo "Image not found";
                                                }
                                                ?>
                                                </td>
                                                <td><?php $equipmentNameWords = explode(' ', htmlentities($result->equipment_name), 2);
                                                          echo $equipmentNameWords[0] . "<br>" . $equipmentNameWords[1];?>
                                                </td>
                                                <td class="description-cell">
                                                    <?php echo htmlentities($result->description);?></td>
                                                <td><?php
                                                $date = new DateTime($result->created_at);
                                                echo htmlentities($date->format('Y-m-d'));
                                                ?></td>

                                                <td>
                                                    <a href='#' data-toggle='modal' data-target='#edit_equipment'
                                                        title='Edit'
                                                        class='btn text-xs text-white btn-blue action-icon'><i
                                                            class='fa fa-pencil'></i></a>

                                                    <a href='#' data-toggle='modal' data-target='#delete_hospital'
                                                        title='Delete'
                                                        class='btn text-xs text-white btn-danger action-icon ml-2'><i
                                                            class='fa fa-trash'></i></a>
                                                </td>
                                            </tr>

                                            <?php $cnt++;} }?>

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