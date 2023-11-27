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
				<h5 class="modal-title">Add New Hospital</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="POST" enctype="multipart/form-data">
					<h2>PERSONAL INFORMATION</h2>
					<div class="form-row">
						<div class="form-group col-md-3">
							<label for="hospital-name">Hospital Name </label>
							<input name="hospital-name" class="form-control" type="text" placeholder="Hospital Name">
						</div>
						<div class="form-group col-md-3">
							<label for="location">Location</label>
							<input name="location" class="form-control" type="text" placeholder="Location">
						</div>
						<div class="form-group col-md-3">
							<label for="institution">Institution </label>
							<select class="form-control select" name="institution">
								<option disabled selected>Select institution</option>
								<option>sample institution</option>
								<option>sample institution</option>
								<option>sample institution</option>
							</select>
						</div>
						<div class="form-group col-md-3">
							<label for="region">Region </label>
							<select class="form-control select" name="region">
								<option disabled selected>Select Region</option>
								<option>sample region</option>
								<option>sample region</option>
								<option>sample region</option>
							</select>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-3">
							<label for="equipment">Equipment</label>
							<input type="text" class="form-control" name="equipment" placeholder="Equipment">
						</div>
					</div>

					<h2 class="mt-3 second-h2">ACCOUNT INFORMATION</h2>
					<div class="form-row">
						<div class="form-group col-md-3">
							<label for="surname">Surname </label>
							<input name="surname" class="form-control" type="text" placeholder="Surname">
						</div>
						<div class="form-group col-md-3">
							<label for="given-name">Given name</label>
							<input name="given-name" class="form-control" type="text" placeholder="Given Name">
						</div>
						<div class="form-group col-md-3">
							<label for="middle-name">Middle Name (Optional) </label>
							<input type="text" class="form-control" name="middle-name" placeholder="Middle Name" placeholder="Middle Name">
						</div>
						<div class="form-group col-md-3">
							<label for="suffix">Suffix </label>
							<select class="form-control select" name="suffix">
								<option disabled selected>Select Suffix</option>
								<option>Mr.</option>
								<option>Mrs.</option>
								<option>Ms.</option>
							</select>
						</div>
					</div>

					<div class="form-row">
						<div class="form-group col-md-3">
							<label for="email">Email Address</label>
							<input name="email" class="form-control" type="email" placeholder="email">
						</div>
						<div class="form-group col-md-3">
							<label for="password">Password</label>
							<input class="form-control" name="password" type="password" placeholder="pasword">
						</div>
						<div class="form-group col-md-3">
							<label for="contact-number">Contact Number</label>
							<input type="tel" class="form-control" name="contact-number" placeholder="Contact Number">
						</div>
						<div class="form-group col-md-3">
							<label for="gender">Gender</label>
							<select class="form-control select" name="gender">
								<option disabled selected>Select Gender</option>
								<option>Male</option>
								<option>Female</option>
								<option>Others</option>
							</select>
						</div>
					</div>

					<div class="submit-section">
						<button type="submit" name="add_hospital" class="btn btn-primary submit-btn">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>