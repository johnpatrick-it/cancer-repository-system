<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="This is a Philippine Cancer Center HR Management System">
    <meta name="keywords" content="PCC-HRMS, HRMS, Human Resource, Capstone, System, HR">
    <meta name="author" content="Heionim">
    <meta name="robots" content="noindex, nofollow">
    <title>PCC HRMS</title>

    <style>
        .page-wrapper {
            padding: 4em;
        }

        #info-txt {
            padding-left: 10rem;
        }

        hr {
            width: 80%;
        }

        input,
        select {
            color: #204A3D;
            border-radius: 5px;
            border: 1px solid #285D4D;
            outline: none;
            padding: 5px;
            font-size: 14px;
            width: 100%;
            box-sizing: border-box;
            margin-bottom: 10px;

        }

        .submit-btn input {
            background-color: #204A31E5;
            color: white;
            font-weight: bold;
            border: none;
            margin-top: 30px;
            padding: 10px;
            width: 60%;
            box-shadow: 0px 4px 4px 0px #0000004D;
        }

        .left-side-space {
            margin-left: 4rem;
        }

        .two-column-layout {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            margin-top: 40px;
        }

        .two-column-layout .first-col {
            width: 100%;
            margin-bottom: 20px;
            padding-left: 10rem;
        }

        .two-column-layout .third-col {
            width: 100%;
            margin-bottom: 20px;
            padding-right: 10rem;
        }
    </style>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="./profiles/pcc-logo1.png">

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">

    <!-- Lineawesome CSS -->
    <link rel="stylesheet" href="assets/css/line-awesome.min.css">

    <!-- Chart CSS -->
    <link rel="stylesheet" href="assets/plugins/morris/morris.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
</head>

<body>

    <div class="main-wrapper">

        <?php include_once("includes/header.php"); ?>
        <?php include_once("includes/sidebar.php"); ?>

        <div class="page-wrapper">
            <div class="content container-fluid">

                <h2 id="info-txt">Edit Patient</h2>
                <hr>

                <form action="" class="" method="post">
                    <div class="two-column-layout">

                        <div class="col-md-5 first-col">
                            <h3 id="info-txt">Personal Information</h3>
                            <div class="left-side-space">
                                <label>Given name</label>
                                <input type="text" name="firstname" id="firstname" value="">

                                <label>Surname</label>
                                <input type="text" name="lastname" id="lastname" value="">

                                <label>Middle name</label>
                                <input type="text" name="middlename" id="middlename" value="">

                                <label>Gender</label>
                                <select name="gender" id="gender">
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>

                                <label>Age</label>
                                <input type="text" name="age" id="age" value="">
                            </div>
                        </div>

                        <div class="col-md-2 second-col">
                            <!-- SPACE BETWEEN -->
                        </div>

                        <div class="col-md-5 third-col">
                            <h3 id="info-txt">Cancer Information</h3>
                            <div class="left-side-space">
                                <label>Cancer Type</label>
                                <select name="cancer-type" id="cancer-type">
                                    <option value="test">TEST</option>
                                    <option value="test">TEST</option>
                                    <option value="test">TEST</option>
                                </select>

                                <label>Cancer Stage</label>
                                <select name="cancer-stage" id="cancer-stage">
                                    <option value="test">TEST</option>
                                    <option value="test">TEST</option>
                                    <option value="test">TEST</option>
                                </select>

                                <label>Cancer Status</label>
                                <select name="cancer-status" id="cancer-status">
                                    <option value="test">TEST</option>
                                    <option value="test">TEST</option>
                                    <option value="test">TEST</option>
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-12 text-center">
                        <div class="submit-btn">
                            <input type="submit" name="submit" value="&#10004; Save Changes" required>
                        </div>
                    </div>
                </form>

            </div>
        </div>


    </div>


    <script src="assets/js/jquery-3.2.1.min.js"></script>

    <!-- Bootstrap Core JS -->
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

    <!-- Slimscroll JS -->
    <script src="assets/js/jquery.slimscroll.min.js"></script>

    <!-- Chart JS -->
    <script src="assets/js/chart.js"></script>

    <!-- Custom JS -->
    <script src="assets/js/app.js"></script>

    <script>
        function confirmSubmission() {
            var confirmation = confirm("Are you sure that the information details are correct? Before you update the information");
            return confirmation;
        }
    </script>

</body>

</html>