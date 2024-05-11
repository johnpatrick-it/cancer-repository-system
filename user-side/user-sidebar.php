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
        font-size: 1rem;
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
                    <a href="user-landing-page.php">
                        <span class="user-img d-inline-block position-relative">
                            <img src="../profiles/pcc-logo.png" alt="User Picture" class="rounded-circle img-thumbnail neon-border">
                        </span>
                    </a>
                    <a href="#">
                        <span class="text-white small user-role">
                            <?php echo $hospital_name; ?> Hospital
                        </span>
                    </a>
                </li>

                <!-- User Dashboard --> 
                <li class="mt-5">
                    <a href="user-landing-page.php">
                        <i class="la la-dashboard"></i>
                        <span>User Dashboard</span>
                    </a>
                </li>

                <!-- Patient Registry -->
                <li>
                    <a href="patient-form-v2.php" id="cancer-cases-link">
                        <i class="la la-user-plus"></i>
                        <span>Cancer Cases Repository</span>
                    </a>
                </li>
                <li id="attach-file-link" style="display: none;">
                    <a href="file-insertion.php">
                        <i class="la la-file-text-o"></i>
                        <span>Bulk Case Insertion</span>
                    </a>
                </li>

                <!-- Manage Patient -->
                <li>
                    <a href="manage-patient.php">
                        <i class="la la-users"></i>
                        <span>Manage Repository</span>
                    </a>
                </li>

                <!-- Patient Report -->
                <li>
                    <a href="patient-report.php">
                        <i class="la la-file-text-o"></i>
                        <span>Repository Logs</span>
                    </a>
                </li>

                <!-- LOGOUT -->
                <li class="out-container">
                    <a class="out-button" href="functions/user-logout-function.php"  onclick="confirmLogout(event)">
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
                window.location.href = "../functions/user-logout-function.php";
            } else {
                console.log("Logout canceled");
            }
        });
    }
</script>

<script>
   // Get the current URL
   var currentUrl = window.location.href;

// Check if the current URL contains 'patient-form-v2.php'
if (currentUrl.indexOf('patient-form-v2.php') !== -1) {
    // Show the 'Attach File Instead' link
    document.getElementById('attach-file-link').style.display = 'block';
}else if (currentUrl.indexOf('file-insertion.php') !== -1){
    document.getElementById('attach-file-link').style.display = 'block';
}
</script>
