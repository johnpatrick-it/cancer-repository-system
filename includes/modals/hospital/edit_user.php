<div id="edit_user" class="modal custom-modal fade" role="dialog">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Edit user information</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="editUserForm" method="post">
					<div class="row">
						<!-- Hidden input field to store the Hospital ID -->
						<input type="hidden" id="editrepoId">
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-form-label">First Name</span></label>
								<input class="form-control" id="editfirstName" type="text" placeholder="First Name">
							</div>
						</div>
						
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-form-label">Middle Name</span></label>
								<input class="form-control" id="editmiddleName" type="text" placeholder="Middle Name">
							</div>
						</div>

						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-form-label">Last Name</span></label>
								<input class="form-control" id="editlastName" type="text" placeholder="Last Name">
							</div>
						</div>

						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-form-label">Hospital Affiliated With</label>
								<select class="form-control select" id="editAffiliated" required>
								<option value="">Select Hospital</option>
								<?php 
								include('includes/config.php');

								$query = "SELECT hospital_id, hospital_name FROM hospital_general_information";
								$result = pg_query($db_connection, $query);

								if ($result && pg_num_rows($result) > 0) {
									while ($row = pg_fetch_assoc($result)) {
										echo "<option value='" . $row['hospital_id'] . "'>" . $row['hospital_name'] . "</option>";
									}
								} else {
									echo "<option value=''>No hospitals found</option>";
								}
							?>
							</select>
							</div>
						</div>

						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-form-label">Position</span></label>
								<input class="form-control" id="editPosition" type="text" placeholder="Position">
							</div>
						</div>
				
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-form-label">Email</span></label>
								<input class="form-control" id="editEmail" type="text" placeholder="Email">
							</div>
						</div>

						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-form-label">Password</span></label>
								<input class="form-control" id="editPassword" type="password" placeholder="Password">
							</div>
						</div>
				
						<div class="col-sm-12">
						<div class="submit-section">
							<button class="btn btn-primary submit-btn">Save</button>
						</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- Add the necessary JavaScript libraries -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@latest"></script>
<script>
$(document).ready(function() {
    const $editBody = $("#edit_user");
    const $editForm = $("#editUserForm");

    // Click handler for edit action
    $(document).on("click", ".edituser-action", function() {
        // Extract data from the clicked row
        const repoId = $(this).data("repo-id");
        const firstName = $(this).closest("tr").find(".first-name").text();
        const middleName = $(this).closest("tr").find(".middle-name").text();
        const lastName = $(this).closest("tr").find(".last-name").text();
        const affiliated = $(this).closest("tr").find(".hospital-affiliated").text();
        const position = $(this).closest("tr").find(".user-position").text();
        const email = $(this).closest("tr").find(".user-email").val(); // Update to .val()
        const password = $(this).closest("tr").find(".user-password").val(); // Update to .val()

        console.log("Repo ID:", repoId);
        console.log("First Name:", firstName);
        console.log("Middle Name:", middleName);
        console.log("Last Name:", lastName);
        console.log("Hospital Affiliated With:", affiliated);
        console.log("Position:", position);
        console.log("Email:", email);
        console.log("Password:", password);

        // Populate the edit form fields
        $("#editrepoId").val(repoId);
        $("#editfirstName").val(firstName);
        $("#editmiddleName").val(middleName);
        $("#editlastName").val(lastName);
        $("#editAffiliated").val(affiliated);
        $("#editPosition").val(position);
        $("#editEmail").val(email);
        $("#editPassword").val(password);

        // Show the edit modal
        $editBody.modal("show");
    });

    // Edit Hospital Form Submission
    $editForm.submit(function(event) {
        event.preventDefault();

        // Retrieve updated user data from the form
        const newrepoId = $("#editrepoId").val();
        const newfirstName = $("#editfirstName").val();
        const newmiddleName = $("#editmiddleName").val();
        const newlastName = $("#editlastName").val();
        const newAffiliated = $("#editAffiliated").val();
        const newPosition = $("#editPosition").val();
        const newEmail = $("#editEmail").val();
        const newPassword = $("#editPassword").val();

        console.log("New Repo ID:", newrepoId);
        console.log("New First Name:", newfirstName);
        console.log("New Middle Name:", newmiddleName);
        console.log("New Last Name:", newlastName);
        console.log("New Hospital Affiliated With:", newAffiliated);
        console.log("New Position:", newPosition);
        console.log("New Email:", newEmail);
        console.log("New Password:", newPassword);

        // AJAX request to update user information
        $.post("/includes/modals/hospital/update_user_function.php", {
            repo_id: newrepoId,
            first_name: newfirstName,
            middle_name: newmiddleName,
            last_name: newlastName,
            affiliated: newAffiliated,
            position: newPosition,
            email: newEmail,
            password: newPassword,
        })
        .done(function(response) {
            console.log("Server Response:", response);
            if (response === "success") {
                // Show SweetAlert alert for success
                Swal.fire({
                    title: 'Success',
                    text: 'User information updated successfully!',
                    icon: 'success',
                    confirmButtonText: 'OK',
                    showConfirmButton: true, // Show the confirm button
                    confirmButtonColor: '#3085d6', // Color of the confirm button
                    allowOutsideClick: false, // Prevent dismissing the alert by clicking outside
                }).then((result) => {
                    // Redirect to the desired page when the confirm button is clicked
                    if (result.isConfirmed) {
                        window.location.href = "../../../user-information.php";
                    }
                });
            } else {
                // Handle failure
                console.log("Failed to update user information.");
            }
        })
        .fail(function(xhr, status, error) {
            console.error("AJAX Error:", error);
        });
    });
});


</script>


