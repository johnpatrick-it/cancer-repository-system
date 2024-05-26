<?php
session_start();
include_once("../../includes/config.php");

$AdminID = $_SESSION['admin_id'] ?? '';
error_reporting(E_ALL);

if (!isset($_SESSION['admin_id']) || empty($_SESSION['admin_id'])) {
    header('.../login.php');
    exit;
}


$AdminID = $_SESSION['admin_id'] ?? '';
$token = $_SESSION['token'] ?? '';



?>

<style>
@media (max-width: 768px) {
    .sidebar {
        display: none;
    }
}

/* User Profile Img */
.neon-border {
    border: 2px solid #0B72BD;
    box-shadow: 0 0 10px #0B72BD;
}

.user-img {
    padding-bottom: 1.2rem;
}

.user-img img {
    width: 6rem;
    height: auto;
}

.profile-block {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.user-role {
    margin-top: -1.5rem;
    font-size: 0.8rem;
}

/* LOGOUT */
.out-container .out-button {
    position: fixed;
    bottom: 0;
    left: 0;
}

#logo {
    display: none;
}
</style>

<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="profile-block">
                    <a href="./user-landing-page.php">
                        <span class="user-img d-inline-block position-relative">
                            <img src="./profiles/pcc-logo.png" alt="User Picture"
                                class="rounded-circle img-thumbnail neon-border">
                        </span>
                    </a>
                    <a href="#">
                        <span class="text-white small user-role">
                            CANCER REPOSITORY ADMIN
                        </span>
                    </a>
                </li>

                <!-- DASHBOARD -->
                <li class="sample-active mt-5"><a href="./index.php"><i class="la la-dashboard"></i> <span>
                            Dashboard</span> </a></li>

                <!-- CANCER STATISTICS
                <li><a href="./cancerstatistic.php"><i class="la la-bar-chart"></i><span>Cancer Statistics</span></a>
                </li>
                 -->
                <!-- HOSPITAL MAPPING -->
                <li><a href="./mapping.php"><i class="la la-map"></i><span>Hospital Mapping</span></a></li>

                <li><a href="./cancer_mapping.php"><i class="la la-users"></i><span>Cancer Cases Data</span></a></li>

                <!-- USER INFORMATION -->
                <li><a href="./user-information.php"><i class="la la-user"></i><span>User Information</span></a></li>
                
                <!-- HOSPITAL INFORMATION -->
                <li><a href="./hospital-information.php"><i class="la la-medkit"></i><span>Hospital Information</span></a></li>

                <!-- HOSPITAL EQUIPMENT INFORMATION -->
                <li><a href="./hospital-equipment-table.php"><i class="la la-file-text-o"></i></i><span>Equipment Information</span></a></li>

                <!-- ACTIVITY LOGS
                <li><a href="./activity-logs.php"><i class="la la-history"></i><span>Activity Logs</span></a></li>
                -->


                <br>
                <br>
                <br>
                <!-- LOGOUT -->
                <li class="out-container">
                    <a class="out-button" href="functions/logout-function.php" onclick="confirmLogout(event)">
                        <i class="la la-power-off"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>




<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



<script>
document.addEventListener("DOMContentLoaded", function() {
    var sidebarMenuItems = document.querySelectorAll('.sidebar-menu a');

    sidebarMenuItems.forEach(function(item) {
        item.addEventListener('click', function() {
            var userRoleText = document.querySelector('.user-role');
            userRoleText.style.display = (userRoleText.style.display === 'none' || userRoleText
                .style.display === '') ? 'block' : 'none';
        });
    });
});
</script>

<script>
function confirmLogout(event) {
    event.preventDefault();

    Swal.fire({
        title: 'Are you sure you want to logout?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, logout!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "functions/logout-function.php";
        } else {
            console.log("Logout canceled");
        }
    });
}
</script>