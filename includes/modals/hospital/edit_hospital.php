<div id="edit_hospital" class="modal custom-modal fade" role="dialog">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Edit Hospital</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form>
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-form-label">Hospital Name</span></label>
								<input class="form-control"  type="text" placeholder="Hospital Location">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-form-label">Hospital Level</label>
								<input class="form-control"  type="text" placeholder="Hospital Level">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-form-label">Type of Institution</span></label>
								<input class="form-control"  type="text" placeholder="Type of Institution">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group col-md-3">
								<label for="region">Region</label>
								<select class="form-control select" name="region" id="region"></select>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label for="province">Province</label>
								<select class="form-control select" name="province" id="province"></select>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group col-md-3">
								<label for="city">City/Municipality</label>
								<select class="form-control select" name="city" id="city"></select>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group col-md-3">
								<label for="barangay">Barangay</label>
								<select class="form-control select" name="barangay" id="barangay"></select>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-form-label">Equipments</label>
								<input class="form-control" type="text">
							</div>
						</div>

						<div class="submit-section">
							<button class="btn btn-primary submit-btn">Save</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>


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