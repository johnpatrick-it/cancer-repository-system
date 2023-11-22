<style>
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
                <!-- PROFILE -->
                <li class="profile-block">
                    <a href="#">
                        <span class="user-img d-inline-block position-relative">
                            <img src="/cancer-repository-system/profiles/<?php echo htmlentities($result->Picture); ?>" alt="User Picture" class="rounded-circle img-thumbnail neon-border">
                        </span>
                    </a>
                    <a href=" #"><span class="text-white h4">Heionim</span></a>
                    <a href="#"><span class="text-white small user-role">CANCER REPOSITORY ADMIN</span></a>
                </li>
                <hr class="bg-white w-100 mt-2">

                <!-- DASHBOARD -->
                <li class="sample-active mt-5"><a href="index.php"><i class="la la-dashboard"></i> <span> Dashboard</span> </a></li>

                <!-- HOSPITAL AND REPO USER REGISTRATION -->
                <li class="submenu">
                    <a href="#"><i class="la la-external-link-square"></i> <span>Create account</span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a href="/cancer-repository-system/includes/hospital-registration.php">Hospital Creation</a></li>
                        <li><a href="#">User Creation</a></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#"><i class="la la-user"></i> <span>Geography</span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a href="#">Hospital Location</a></li>
                        <li><a href="#">Maps by Indicators</a></li>
                    </ul>
                </li>
                <!-- ACTIVITY LOGS -->
                <li>
                    <a href="#"><i class="la la-users"></i><span>Activity Logs</span></a>
                </li>

                <!-- SETTINGS -->
                <li>
                    <a href="#"><i class="la la-cogs"></i><span>Settings</span></a>
                </li>

                <!-- LOGOUT -->
                <li class="out-container">
                    <a class="out-button" href="#"><i class="la la-power-off"></i><span>Logout</span></a>
                </li>
            </ul>
        </div>
    </div>
</div>