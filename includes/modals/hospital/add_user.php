<?php
session_start();
include_once("../../../includes/config.php");

$AdminID = $_SESSION['admin_id'] ?? '';
error_reporting(E_ALL);

if (!isset($_SESSION['admin_id']) || empty($_SESSION['admin_id'])) {
    header('.../login.php');
    exit;
}

?>



<style>
h2 {
		font-size: 1rem;
		margin-bottom: 1rem;
	}

	.second-h2 {
		border-top: 1px solid grey;
		padding-top: 10px;
	}
</style>

<div id="add_hospital" class="modal custom-modal fade " role="dialog">
	<div class="modal-dialog modal-dialog-centered modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Add New User</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>			
			</div>
			<div class="modal-body">
				<form method="POST" action="/includes/modals/hospital/save_user.php" enctype="multipart/form-data" autocomplete="off">
					<h2>USER INFORMATION</h2>
					<div class="form-row">
						<div class="form-group col-md-3">
							<label for="first-name">First Name</label>
							<input name="first-name" class="form-control" type="text" placeholder="User's First Name" required>
						</div>
                        <div class="form-group col-md-3">
							<label for="middle-name">Middle Name</label>
							<input name="middle-name" class="form-control" type="text" placeholder="User's Middle Name" required>
						</div>
                        <div class="form-group col-md-3">
							<label for="last-name">Last Name</label>
							<input name="last-name" class="form-control" type="text" placeholder="User's Last Name" required>
						</div>
                        <div class="form-group col-md-3">
                            <label for="user-hospital">Hospital Affiliated With</label>
                            <select name="user-hospital" class="form-control" required>
                                <option value="">Select Hospital</option>
                                <?php
                            	$query = "SELECT DISTINCT ON (hospital_name) hospital_name, hospital_id FROM hospital_general_information";
                                $result = pg_query($db_connection, $query);

                                if ($result && pg_num_rows($result) > 0) {
                                    while ($row = pg_fetch_assoc($result)) {
                                        echo "<option value='" . $row['hospital_id'] . "'>" . $row['hospital_name'] . "</option>";
                                    }
                                } else {
                                    echo "<option value=''>No hospitals found</option>";
                                }
                                // Close database connection
                                pg_close($db_connection);
                                ?>
                            </select>
                        </div>
					</div>
					<div class="form-row">
					    <div class="form-group col-md-3">
							<label for="position">Position</label>
							<input name="position" class="form-control" type="text" placeholder="User's Work" required>
						</div>
                        <div class="form-group col-md-3">
							<label for="email">Email</label>
							<input name="email" class="form-control" type="email" placeholder="User's Email" required>
						</div>
                        <div class="form-group col-md-3">
							<label for="password">Password</label>
							<input name="password" class="form-control" type="password" placeholder="Password" required>
						</div>
					</div>
					<div class="submit-section">
						<button type="submit" name="add_user" class="btn btn-primary submit-btn">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
