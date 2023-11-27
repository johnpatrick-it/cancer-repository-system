<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://f001.backblazeb2.com/file/buonzz-assets/jquery.ph-locations-v1.0.0.js"></script>
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
					<h2>HOSPITAL INFORMATION</h2>
					<div class="form-row">
						<div class="form-group col-md-3">
							<label for="hospital-name">Hospital Name </label>
							<input name="hospital-name" class="form-control" type="text" placeholder="Hospital Name">
						</div>
						<div class="form-group col-md-3">
							<label for="level">Hospital Level</label>
							<label for="level">Institution </label>
							<select class="form-control select" name="level">
								<option disabled selected>Select Level</option>
								<option>Level 1 General Hospital</option>
								<option>Level 2 General Hospital</option>
								<option>Level 3 General Hospital</option>
							</select>
						</div>
						<div class="form-group col-md-3">
							<label for="institution">Hospital Institution </label>
							<select class="form-control select" name="institution">
								<option disabled selected>Select institution</option>
								<option>Government</option>
								<option>Private</option>
							</select>
						</div>
						<div class="form-group col-md-3">
							<label for="region">Region</label>
							<select class="form-control select" name="region" id="my-region-dropdown"></select>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-3">
							<label for="province">Province</label>
							<select class="form-control select" name="province" id="my-province-dropdown"></select>
						</div>
						<div class="form-group col-md-3">
							<label for="city_municipality">City/Municipality</label>
							<select class="form-control select" name="city_municipality" id="my-city-dropdown"></select>
						</div>
						<div class="form-group col-md-3">
							<label for="barangay">Barangay</label>
							<select class="form-control select" name="barangay" id="my-barangay-dropdown"></select>
						</div>
						<div class="form-group col-md-3">
							<label for="street">Street Adress</label>
							<input type="text" class="form-control" name="street" placeholder="Street Adress">
						</div>
					</div>
					
					<h2 class="mt-3 second-h2">HOSPITAL EQUIPMENTS</h2>
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

<script>
   // Initialize the location dropdowns after the modal is shown
   $('#add_hospital').on('shown.bs.modal', function () {
       // Initialize the plugin for each dropdown
       $('#my-region-dropdown').ph_locations({ 'location_type': 'regions' });
       $('#my-province-dropdown').ph_locations({ 'location_type': 'provinces' });
       $('#my-city-dropdown').ph_locations({ 'location_type': 'cities' });
       $('#my-barangay-dropdown').ph_locations({ 'location_type': 'barangays' });
       
       // Fetch the data for each dropdown
       $('#my-region-dropdown').ph_locations('fetch_list');
       $('#my-province-dropdown').ph_locations('fetch_list');
       $('#my-city-dropdown').ph_locations('fetch_list');
       $('#my-barangay-dropdown').ph_locations('fetch_list');
   });
</script>