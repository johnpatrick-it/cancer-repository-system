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
                    <a href="../admin-index.php"><span class="text-white small user-role">CANCER REPOSITORY ADMIN</span></a>
                </li>
                <br>
                <br>
                <br>

                <!-- User Dashboard -->
                <li><a href="./user-landing-page.php"><i class="la la-dashboard"></i><span>User Dashboard</span></a></li>

                <!-- Manage Patient -->
                <li><a href="./manage-patient.php"><i class="la la-users"></i><span>Manage Patient</span></a></li>

                <!-- Patient Registry -->
                <li><a href="./patient-registry-one.php"><i class="la la-user-plus"></i><span>Patient Registry</span></a></li>

                <!-- Patient Report -->
                <li><a href="./patient-report.php"><i class="la la-file-text-o"></i><span>Patient Report</span></a></li>

                <!-- LOGOUT -->
                <li class="out-container">
                    <a class="out-button" href="logout.php"><i class="la la-power-off"></i><span>Logout</span></a>
                </li>
            </ul>
        </div>
    </div>
</div>