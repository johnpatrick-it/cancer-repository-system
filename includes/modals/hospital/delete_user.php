<div class="modal custom-modal fade" id="delete_user" role="dialog">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-body">
				<div class="form-header">
					<h3>Delete Hospital</h3>
					<p>Are you sure want to delete?</p>
				</div>
				<div class="modal-btn delete-action">
					<div class="row">
						<div class="col-6">
							<a href="#" id="deleteUserData" class="btn btn-primary continue-btn">Delete</a>
						</div>
						<div class="col-6">
							<a href="javascript:void(0);" data-dismiss="modal"  class="btn btn-primary cancel-btn">Cancel</a>
						</div>
					</div>
				</div>
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
    const $deleteBody = $("#delete_user");
    const $deleteBtn = $("#deleteUserData");

    $(document).on("click", ".delete-action", function() {
        const repoId = $(this).data("repo-id");
        $deleteBtn.data("repoId", repoId);
        $deleteBody.modal("show"); 
    });

    $deleteBtn.click(function(event) {
        event.preventDefault();
        const repoId = $(this).data("repoId");

        // Send delete request to the server
        $.post("/includes/modals/hospital/delete_user_function.php", {
            repo_id: repoId
        }, function(response) {
            if(response === "success") {
                // Hide modal
                $deleteBody.modal("hide");
                // Optionally, display a confirmation message
                alert("User deleted successfully.");
            } else {
                // Handle specific errors
                console.log("Failed to delete user");
                console.log("Error response from server:", response);
            }
        })
        .fail(function(xhr, status, error) {
            // Log AJAX request failure
            console.error("AJAX Error:", error);
        });
    });
});

</script>