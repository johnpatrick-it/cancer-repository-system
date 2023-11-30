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

    .user-img img {
        width: 6rem;
        height: auto;
    }

    .profile-block {
        margin: 0 0 0 -2rem;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .user-role {
        margin-top: -1.5rem;
    }

    /* ACTIVE NAV STATE */
    .sample-active {
        background-color: #A88C0A;
    }

    /* LOGOUT */
    .out-container .out-button {
        position: fixed;
        bottom: 0;
        left: 0;
    }
</style>

<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="profile-block">
                    <a href="#">
                        <span class="user-img d-inline-block position-relative">
                            <img src="./profiles/pcc-logo.png" alt="User Picture" class="rounded-circle img-thumbnail neon-border">
                        </span>
                    </a>
                    <br>
                    <a href="../admin-index.php"><span class="text-white small user-role">CANCER REPO ADMIN</span></a>
                </li>

                <!-- DASHBOARD -->
                <li class="sample-active mt-5"><a href="./index.php"><i class="la la-dashboard"></i> <span> Dashboard</span> </a></li>

                <!-- CANCER STATISTICS -->
                <li><a href="#"><i class="la la-bar-chart"></i><span>Cancer Statistics</span></a></li>

                <!-- HOSPITAL INFORMATION -->
                <li><a href="./hospital-information.php"><i class="la la-medkit"></i><span>Hospital Information</span></a></li>

                <!-- USER INFORMATION -->
                <!-- <li><a href="./user-information.php"><i class="la la-user"></i><span>User Information</span></a></li> -->

                <!-- HOSPITAL MAPPING -->
                <li><a href="../mapping.php"><i class="la la-map"></i><span>Hospital Mapping</span></a></li>

                <!-- ACTIVITY LOGS -->
                <li><a href="./activity-logs.php"><i class="la la-history"></i><span>Activity Logs</span></a></li>

                <!-- SETTINGS -->
                <li><a href="#"><i class="la la-file-text"></i><span>Personal Attendance</span></a></li>

                <!-- LOGOUT -->
                <li class="out-container">
                    <a class="out-button" href="logout.php"><i class="la la-power-off"></i><span>Logout</span></a>
                </li>
            </ul>
        </div>
    </div>
</div>