<div id="edit_equipment" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Hospital</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editHospitalForm" method="post">
                    <div class="row">

                        <!-- Hidden input field to store the Hospital ID -->
                        <input type="hidden" id="editHospitalId">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-form-label">Hospital Name</span></label>
                                <input class="form-control" id="editHospitalName" type="text"
                                    placeholder="Hospital Location">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-form-label">Hospital Level</label>
                                <select class="form-control select" id="editHospitalLevel" required>
                                    <option disabled selected>Select Level</option>
                                    <option>Level 1 General Hospital</option>
                                    <option>Level 2 General Hospital</option>
                                    <option>Level 3 General Hospital</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-form-label">Type of Institution</span></label>
                                <select class="form-control select" id="editTypeInstitution" required>
                                    <option disabled selected>Select institution</option>
                                    <option>Government</option>
                                    <option>Private</option>
                                </select>
                            </div>
                        </div>


                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="edit-region">Region</label>
                                <select class="form-control select" id="edit-region" type="text"></select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="edit-province">Province</label>
                                <select class="form-control select" id="edit-province" type="text"></select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="edit-city">City/Municipality</label>
                                <select class="form-control select" id="edit-city" type="text"></select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="edit-barangay">Barangay</label>
                                <select class="form-control select" id="edit-barangay" type="text"></select>
                            </div>
                        </div>


                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-form-label">Street</label>
                                <input class="form-control" id="editStreet" type="text">
                            </div>
                        </div>


                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="hospital-equipment">Equipments</label>
                                <div class="input-group">
                                    <select name="editEquipments" id="editEquipments" class="form-control" required>
                                        <option value="" id="editEquipments" disabled selected>Select Medical Equipment
                                        </option>
                                        <?php
										$query = $dbh->query("SELECT equipment_name FROM repo_equipment_category");
										while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
										?>
                                        <option value="<?php echo $row['equipment_name']; ?>">
                                            <?php echo $row['equipment_name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>



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


<!-- PH AUTOMATIC ADDRESS WAG GALIWAN PARANG AWA-->
<script>
$(document).ready(function() {
    // Load Region
    let regionDropdown = $('#edit-region');
    regionDropdown.empty();
    regionDropdown.append('<option selected="true" disabled>Choose Region</option>');
    regionDropdown.prop('selectedIndex', 0);
    const regionUrl = 'ph-json/region.json';

    // Populate dropdown with list of regions
    $.getJSON(regionUrl, function(data) {
        $.each(data, function(key, entry) {
            regionDropdown.append($('<option></option>').attr('value', entry.region_code).text(
                entry.region_name));
        });
    });

    // Change or Select Region
    $('#edit-region').on('change', function() {
        // Load Provinces
        var region_code = $(this).val();
        var region_text = $(this).find("option:selected").text();
        let region_input = $('#edit-region-text');
        region_input.val(region_text);

        let provinceDropdown = $('#edit-province');
        provinceDropdown.empty();
        provinceDropdown.append('<option selected="true" disabled>Choose State/Province</option>');
        provinceDropdown.prop('selectedIndex', 0);

        // Filter & fill provinces based on selected region
        var provinceUrl = 'ph-json/province.json';
        $.getJSON(provinceUrl, function(provinceData) {
            var provinceResult = provinceData.filter(function(value) {
                return value.region_code == region_code;
            });

            provinceResult.sort(function(a, b) {
                return a.province_name.localeCompare(b.province_name);
            });

            $.each(provinceResult, function(key, entry) {
                provinceDropdown.append($('<option></option>').attr('value', entry
                    .province_code).text(entry.province_name));
            });
        });
    });

    // Change or Select Province
    $('#edit-province').on('change', function() {
        var province_code = $(this).val();
        var province_text = $(this).find("option:selected").text();
        let province_input = $('#province-text');
        province_input.val(province_text);

        let cityDropdown = $('#edit-city');
        cityDropdown.empty();
        cityDropdown.append('<option selected="true" disabled>Choose City/Municipality</option>');
        cityDropdown.prop('selectedIndex', 0);

        // Filter & fill cities based on selected province
        var cityUrl = 'ph-json/city.json';
        $.getJSON(cityUrl, function(cityData) {
            var cityResult = cityData.filter(function(value) {
                return value.province_code == province_code;
            });

            cityResult.sort(function(a, b) {
                return a.city_name.localeCompare(b.city_name);
            });

            $.each(cityResult, function(key, entry) {
                cityDropdown.append($('<option></option>').attr('value', entry
                    .city_code).text(entry.city_name));
            });
        });
    });

    // Change or Select City
    $('#edit-city').on('change', function() {
        var city_code = $(this).val();
        var city_text = $(this).find("option:selected").text();
        let city_input = $('#city-text');
        city_input.val(city_text);

        let barangayDropdown = $('#edit-barangay');
        barangayDropdown.empty();
        barangayDropdown.append('<option selected="true" disabled>Choose Barangay</option>');
        barangayDropdown.prop('selectedIndex', 0);

        // Filter & fill barangays based on selected city
        var barangayUrl = 'ph-json/barangay.json';
        $.getJSON(barangayUrl, function(barangayData) {
            var barangayResult = barangayData.filter(function(value) {
                return value.city_code == city_code;
            });

            barangayResult.sort(function(a, b) {
                return a.brgy_name.localeCompare(b.brgy_name);
            });

            $.each(barangayResult, function(key, entry) {
                barangayDropdown.append($('<option></option>').attr('value', entry
                    .brgy_code).text(entry.brgy_name));
            });
        });
    });
});
</script>

<script>
$(document).ready(function() {
    // Set constants
    const pollingInterval = 500; // 500 milliseconds
    const lastTimestampKey = "lastTimestampKey";
    const $editBody = $("#edit_hospital");
    const $editForm = $("#editHospitalForm");

    // Step 4: Edit Hospital Button Click
    $(document).on("click", ".edit-action", function() {
        const hospitalId = $(this).data("hospital-id");
        const hospitalName = $(this).closest("tr").find(".hospital-name").text();
        const hospitalLevel = $(this).closest("tr").find(".hospital-level").text();
        const typeInstitution = $(this).closest("tr").find(".type-of-institution").text();
        const region = $(this).closest("tr").find(".hospital-region").val();
        const province = $(this).closest("tr").find(".hospital-province").val();
        const city = $(this).closest("tr").find(".hospital-city").val();
        const barangay = $(this).closest("tr").find(".hospital_barangay").val();
        const street = $(this).closest("tr").find(".hospital-streets").val();
        const equipments = $(this).closest("tr").find(".hospital-equipments").val();

        // Populate the edit form fields with hospital data
        $("#editHospitalId").val(hospitalId);
        $("#editHospitalName").val(hospitalName);
        $("#editHospitalLevel").val(hospitalLevel);
        $("#editTypeInstitution").val(typeInstitution);
        $("#edit-region").val(region);
        $("#edit-province").val(province);
        $("#edit-city").val(city);
        $("#edit-barangay").val(barangay);
        $("#editStreet").val(street);
        $("#editEquipments").val(equipments);

        // Show the edit modal
        $editBody.modal("show");
    });

    // Step 5: Edit Hospital Form Submission
    $editForm.submit(function(event) {
        event.preventDefault();


        // Retrieve updated hospital data from the form
        const newHospitalId = $("#editHospitalId").val();
        const newHospitalName = $("#editHospitalName").val();
        const newHospitalLevel = $("#editHospitalLevel").val();
        const newTypeInstitution = $("#editTypeInstitution").val();
        const newRegion = $("#edit-region").val();
        const newProvince = $("#edit-province").val();
        const newCity = $("#edit-city").val();
        const newBarangay = $("#edit-barangay").val();
        const newStreet = $("#editStreet").val();
        const newEquipments = $("#editEquipments").val();


        // Example AJAX request to update hospital information
        $.post("includes/modals/hospital/update_hospital.php", {
            hospital_id: newHospitalId,
            hospital_name: newHospitalName,
            hospital_level: newHospitalLevel,
            type_institution: newTypeInstitution,
            region: newRegion,
            province: newProvince,
            city: newCity,
            street: newStreet,
            barangay: newBarangay,
            equipments: newEquipments
        }, function(response) {
            console.log("Server Response:", response); // Add debugging for server response
            if (response === "success") {
                // Close the modal and update data
                $editBody.modal("hide").css('display', 'none');
                // Show SweetAlert alert
                Swal.fire({
                    title: 'Success',
                    text: 'Hospital information updated successfully!',
                    icon: 'success',
                    confirmButtonText: 'OK',
                    showConfirmButton: true, // Show the confirm button
                    confirmButtonColor: '#3085d6', // Color of the confirm button
                    allowOutsideClick: false, // Prevent dismissing the alert by clicking outside
                }).then((result) => {
                    // Redirect to the desired page when the confirm button is clicked
                    if (result.isConfirmed) {
                        window.location.href = "hospital-information.php";
                    }
                });
            } else {
                console.log("Failed to update");
            }


        });


    });
});
</script>



<!-- Add the necessary JavaScript libraries -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@latest"></script>