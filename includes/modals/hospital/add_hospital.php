
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="../assets/js/addressSelector.js"></script>
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
				<form method="POST" action="/includes/modals/hospital/save_hospital.php" enctype="multipart/form-data">
					<h2>HOSPITAL INFORMATION</h2>
					<div class="form-row">
						<div class="form-group col-md-3">
							<label for="hospital-name">Hospital Name </label>
							<input name="hospital-name" class="form-control" type="text" placeholder="Hospital Name" required>
						</div>
						<div class="form-group col-md-3" required>
							<label for="level">Hospital Level</label>
							<label for="level">Institution </label>
							<select class="form-control select" name="level" required>
								<option disabled selected>Select Level</option>
								<option>Level 1 General Hospital</option>
								<option>Level 2 General Hospital</option>
								<option>Level 3 General Hospital</option>
							</select>
						</div>
						<div class="form-group col-md-3">
							<label for="institution">Hospital Institution </label>
							<select class="form-control select" name="institution" required>
								<option disabled selected>Select institution</option>
								<option>Government</option>
								<option>Private</option>
							</select>
						</div>
						<div class="form-group col-md-3">
							<label for="region">Region</label>
							<select class="form-control select" name="region" id="region"></select>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-3">
							<label for="province">Province</label>
							<select class="form-control select" name="province" id="province"></select>
						</div>
						<div class="form-group col-md-3">
							<label for="city">City/Municipality</label>
							<select class="form-control select" name="city" id="city"></select>
						</div>
						<div class="form-group col-md-3">
							<label for="barangay">Barangay</label>
							<select class="form-control select" name="barangay" id="barangay"></select>
						</div>
						<div class="form-group col-md-3">
							<label for="street">Street Adress</label>
							<input type="text" class="form-control" name="street" placeholder="Street Adress" required>
						</div>
					</div>
					
					<h2 class="mt-3 second-h2">HOSPITAL EQUIPMENTS</h2>
						<div class="form-row">
							<div class="form-group col-md-3">
								<label for="hospital-equipment">Oncologists Medical Equipment</label>
								<div class="input-group">
									<input name="hospital-equipment" class="form-control" type="text" placeholder="Medical Equipment"required>
									<div class="input-group-append">
										<button type="button" class="btn btn-primary add-equipment-btn">+</button>
									</div>
								</div>
							</div>
						</div>

					<div class="form-row" id="equipmentContainer">
						<!-- Dapat Dito sya pupunta -->
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
    // Function to remove the entire equipment section
    function removeEquipment(e) {
        e.target.closest('.form-row').remove();
    }
	//NEED FOR OPTIMIZATION FOR THIS AND BUG FIX
    document.querySelector('.add-equipment-btn').addEventListener('click', function() {
        var newTextBox = document.createElement('div');
        newTextBox.className = 'form-group col-md-3';
        newTextBox.innerHTML = `
            <label for="equipment">Equipment</label>
            <div class="input-group">
                <input name="equipment" class="form-control" type="text" placeholder="Equipment">
                <div class="input-group-append">
                    <button type="button" class="btn btn-danger remove-equipment-btn">x</button>
                </div>
            </div>
        `;

        // Add event listener for the remove button
        newTextBox.querySelector('.remove-equipment-btn').addEventListener('click', removeEquipment);

        // Add new text box after the existing input field
        var equipmentSection = document.createElement('div');
        equipmentSection.className = 'form-row';
        equipmentSection.appendChild(newTextBox);

        var formRow = document.querySelector('.form-row');
        formRow.parentNode.insertBefore(equipmentSection, formRow.nextSibling);
    });
</script>


<!-- PH AUTOMATIC ADDRESS WAG GALIWAN PARANG AWA-->
<script>
	$(document).ready(function () {
		// Load Region
		let regionDropdown = $('#region');
		regionDropdown.empty();
		regionDropdown.append('<option selected="true" disabled>Choose Region</option>');
		regionDropdown.prop('selectedIndex', 0);
		const regionUrl = 'ph-json/region.json';

		// Populate dropdown with list of regions
		$.getJSON(regionUrl, function (data) {
			$.each(data, function (key, entry) {
				regionDropdown.append($('<option></option>').attr('value', entry.region_code).text(entry.region_name));
			});
		});

		// Change or Select Region
		$('#region').on('change', function () {
			// Load Provinces
			var region_code = $(this).val();
			var region_text = $(this).find("option:selected").text();
			let region_input = $('#region-text');
			region_input.val(region_text);

			let provinceDropdown = $('#province');
			provinceDropdown.empty();
			provinceDropdown.append('<option selected="true" disabled>Choose State/Province</option>');
			provinceDropdown.prop('selectedIndex', 0);

			// Filter & fill provinces based on selected region
			var provinceUrl = 'ph-json/province.json';
			$.getJSON(provinceUrl, function (provinceData) {
				var provinceResult = provinceData.filter(function (value) {
					return value.region_code == region_code;
				});

				provinceResult.sort(function (a, b) {
					return a.province_name.localeCompare(b.province_name);
				});

				$.each(provinceResult, function (key, entry) {
					provinceDropdown.append($('<option></option>').attr('value', entry.province_code).text(entry.province_name));
				});
			});
		});

		// Change or Select Province
		$('#province').on('change', function () {
			var province_code = $(this).val();
			var province_text = $(this).find("option:selected").text();
			let province_input = $('#province-text');
			province_input.val(province_text);

			let cityDropdown = $('#city');
			cityDropdown.empty();
			cityDropdown.append('<option selected="true" disabled>Choose City/Municipality</option>');
			cityDropdown.prop('selectedIndex', 0);

			// Filter & fill cities based on selected province
			var cityUrl = 'ph-json/city.json';
			$.getJSON(cityUrl, function (cityData) {
				var cityResult = cityData.filter(function (value) {
					return value.province_code == province_code;
				});

				cityResult.sort(function (a, b) {
					return a.city_name.localeCompare(b.city_name);
				});

				$.each(cityResult, function (key, entry) {
					cityDropdown.append($('<option></option>').attr('value', entry.city_code).text(entry.city_name));
				});
			});
		});

		// Change or Select City
		$('#city').on('change', function () {
			var city_code = $(this).val();
			var city_text = $(this).find("option:selected").text();
			let city_input = $('#city-text');
			city_input.val(city_text);

			let barangayDropdown = $('#barangay');
			barangayDropdown.empty();
			barangayDropdown.append('<option selected="true" disabled>Choose Barangay</option>');
			barangayDropdown.prop('selectedIndex', 0);

			// Filter & fill barangays based on selected city
			var barangayUrl = 'ph-json/barangay.json';
			$.getJSON(barangayUrl, function (barangayData) {
				var barangayResult = barangayData.filter(function (value) {
					return value.city_code == city_code;
				});

				barangayResult.sort(function (a, b) {
					return a.brgy_name.localeCompare(b.brgy_name);
				});

				$.each(barangayResult, function (key, entry) {
					barangayDropdown.append($('<option></option>').attr('value', entry.brgy_code).text(entry.brgy_name));
				});
			});
		});
	});
</script>