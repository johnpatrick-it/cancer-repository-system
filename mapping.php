<?php
session_start();
if (!isset($_SESSION['admin_id']) || empty($_SESSION['admin_id'])) {
  header("Location: login.php");
  exit;
}
error_reporting(0);
include('includes/config.php');

if (!$db_connection) {
  die("Connection failed: " . pg_last_error());
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

  <style>
    body {
      height: 140vh;
    }

    .page-header {
      background-color: #fff;
      padding: 20px;
      margin-bottom: 20px;
      border-radius: 5px;
      border-bottom: 1px solid black; /* Added bottom border only */
      color: #fff;
    }

    .page-header .breadcrumb-item.active,
    .page-header .welcome h3,
    .page-header .close {
      font-size:1.9rem;
      color: #204A3D;
    }

    h2 {
      font-size: 1rem;
      border-bottom: 2px solid #ccc;
      padding: 0.5rem;
    }

    thead,
    tbody {
      background-color: #d9d9d9;
      color: #204A3D;
      font-size: 0.8rem;
      text-align: center;
    }

    #container1 {
      display: flex;
      position: absolute;
      margin-left: 50em;
    }

    #description-container {
      margin-left: 20px;
    }

    .description {
      display: none;
    }

    #container2 {
      text-align: center;
    }

    #dropdown {
      margin-bottom: 10px;
    }

    table {
      border-collapse: collapse;
      width: 100%;
    }

    th,
    td {
      padding: 10px;
      padding-bottom: 18px;
      text-align: left;
    }

    th {
      background-color: #f2f2f2;
    }

    tbody td {
      background-color: white;
      border-bottom: 1px solid #000;
    }

    select {
      padding: 18px;
      padding-left: 105px;
      padding-right: 105px;
      border-radius: 8px;
    }

    .zoom-buttons {
      position: absolute;
      top: 10px;
      left: 10px;
    }

    #sar {
      background-color: gray;
    }

    #map-container {
      position: relative;
      width: 40%;
      /* Adjust the width as needed */
      height: 690px;
      overflow: hidden;
      border: 1px solid #ccc;
      padding: auto;
      margin: auto;
      float: left;
      margin-left: 2em;
    }

    #zoom-container {
      position: absolute;
      width: 100%;
      height: 100%;
    }

    #map {
      transition: transform 0.3s ease-in-out;
    }

    #zoom-in-btn,
    #zoom-out-btn,
    #zoom-reset-btn {
      position: absolute;
      top: 10px;
      padding: 10px;
      border: none;
      cursor: pointer;
      z-index: 1;
    }

    #zoom-in-btn {
      left: 10px;
      background-color: #3498db;
      color: #fff;
    }

    #zoom-out-btn {
      left: 50px;
      background-color: #e74c3c;
      color: #fff;
    }

    #zoom-reset-btn {
      left: 90px;
      background-color: green;
      color: #fff;
    }

    .mappingChart {
            display:flex;
            justify-content:center;
            align-items:center;
            border: 1px solid;
            margin: 0 40px;
        }

        /* CSS for desktop styles */

@media only screen and (max-width: 768px) {
  
  .mappingChart {
            display:flex;
            justify-content:center;
            align-items:center;
            border: 1px solid;
            margin: 0 10px;
        }
}

  </style>

  <!-- Favicon -->
  <link rel="shortcut icon" type="image/x-icon" href="./profiles/pcc-logo1.png">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">

  <!-- Fontawesome CSS -->
  <link rel="stylesheet" href="assets/css/font-awesome.min.css">

  <!-- Lineawesome CSS -->
  <link rel="stylesheet" href="assets/css/line-awesome.min.css">

  <!-- Chart CSS -->
  <link rel="stylesheet" href="assets/plugins/morris/morris.css">

  <!-- Main CSS -->
  <link rel="stylesheet" href="assets/css/style.css">

  <!-- Mapping Design CSS -->
  <link rel="stylesheet" href="assets/css/mapping-design.css">

</head>

<body>
  <!-- Main Wrapper -->
  <div class="main-wrapper">

    <!-- Header -->
    <?php include_once("includes/header.php"); ?>

    <!-- Sidebar -->
    <?php include_once("includes/sidebar.php"); ?>

    <div class="page-wrapper">
      <div class="content container-fluid">

        <!-- WELCOME MESSAGE -->
        <div class="page-header">
          <div class="row">
            <div class="col-sm-12">
              <div class="welcome d-flex justify-content-between align-items-center">
                <h3 class="page-title">Hospital Mapping</h3>
              </div>
            </div>
          </div>
        </div>
     
      <div class="mappingChart">
      <div class='tableauPlaceholder' id='viz1710175259510' style='position: relative'><noscript><a href='#'><img alt='Cancer Cases Heatmap + Hospital Location ' src='https:&#47;&#47;public.tableau.com&#47;static&#47;images&#47;Ca&#47;CancerCasesHeatMapHospitalLocation&#47;CancerCasesHeatmapHospitalLocation&#47;1_rss.png' style='border: none' /></a></noscript><object class='tableauViz'  style='display:none;'><param name='host_url' value='https%3A%2F%2Fpublic.tableau.com%2F' /> <param name='embed_code_version' value='3' /> <param name='site_root' value='' /><param name='name' value='CancerCasesHeatMapHospitalLocation&#47;CancerCasesHeatmapHospitalLocation' /><param name='tabs' value='no' /><param name='toolbar' value='yes' /><param name='static_image' value='https:&#47;&#47;public.tableau.com&#47;static&#47;images&#47;Ca&#47;CancerCasesHeatMapHospitalLocation&#47;CancerCasesHeatmapHospitalLocation&#47;1.png' /> <param name='animate_transition' value='yes' /><param name='display_static_image' value='yes' /><param name='display_spinner' value='yes' /><param name='display_overlay' value='yes' /><param name='display_count' value='yes' /><param name='language' value='en-US' /></object></div>                <script type='text/javascript'>                    var divElement = document.getElementById('viz1710175259510');                    var vizElement = divElement.getElementsByTagName('object')[0];                    if ( divElement.offsetWidth > 800 ) { vizElement.style.width='100%';vizElement.style.height=(divElement.offsetWidth*0.75)+'px';} else if ( divElement.offsetWidth > 500 ) { vizElement.style.width='100%';vizElement.style.height=(divElement.offsetWidth*0.75)+'px';} else { vizElement.style.width='100%';vizElement.style.height='727px';}                     var scriptElement = document.createElement('script');                    scriptElement.src = 'https://public.tableau.com/javascripts/api/viz_v1.js';                    vizElement.parentNode.insertBefore(scriptElement, vizElement);                </script>
      </div>


</body>

<!-- jQuery -->
<script src="assets/js/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap Core JS -->
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- Slimscroll JS -->
    <script src="assets/js/jquery.slimscroll.min.js"></script>
    <!-- Chart JS -->
    <script src="assets/plugins/morris/morris.min.js"></script>
    <script src="assets/plugins/raphael/raphael.min.js"></script>
    <script src="assets/js/chart.js"></script>
    <!-- Custom JS -->
    <script src="assets/js/app.js"></script>
    <script src="assets/js/piechart.js"></script>
    <script src="assets/js/barchart.js"></script>
    <script src="assets/js/chart-switcher.js"></script>

</html>