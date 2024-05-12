<?php
session_start();
include_once("../../../includes/config.php");

$AdminID = $_SESSION['admin_id'] ?? '';
error_reporting(E_ALL);

if (!isset($_SESSION['admin_id']) || empty($_SESSION['admin_id'])) {
    header('.../login.php');
    exit;
}


$AdminID = $_SESSION['admin_id'] ?? '';
$token = $_SESSION['token'] ?? '';

$host = "user=postgres.tcfwwoixwmnbwfnzchbn password=sbit4e-4thyear-capstone-2023 host=aws-0-ap-southeast-1.pooler.supabase.com port=5432 dbname=postgres";
                                            
try {
    $dbh = new PDO("pgsql:" . $host);
    
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
<!-- Include SweetAlert2 library -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

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
                <form method="POST" action="includes/modals/hospital/save_hospital.php" enctype="multipart/form-data"
                    autocomplete="off">
                    <h2>HOSPITAL INFORMATION</h2>
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="hospital_name">Hospital Name </label>
                            <input name="hospital_name" class="form-control" type="text" placeholder="Hospital Name"
                                required="true">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="level">Hospital Level</label>
                            <select class="form-control select" name="level" id="level" required="true">
                                <option disabled selected>Select Level</option>
                                <option value="Non Hospital">Non-Hospital</option>
                                <option value="Level 1 General Hospital">Level 1 General Hospital</option>
                                <option value="Level 2 General Hospital">Level 2 General Hospital</option>
                                <option value="Level 3 General Hospital">Level 3 General Hospital</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3" id="institutionFieldLevel3">
                            <label for="institution">Hospital Category</label>
                            <select class="form-control select" name="institution_level3" required="true">
                                <option disabled selected>Select Hospital Category</option>
                            </select>
                        </div>

                        <div class="form-group col-md-3" id="specialtyField">
                            <label for="specialty">Specialty</label>
                            <select class="form-control select" name="specialty" required="true">
                                <option disabled selected>Select Hospital Specialty</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="region">Region</label>
                            <select class="form-control select" name="region" id="region" required="true"></select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="province">Province</label>
                            <select class="form-control select" name="province" id="province" required="true"></select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="city">City/Municipality</label>
                            <select class="form-control select" name="city" id="city" required="true"></select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="barangay">Barangay</label>
                            <select class="form-control select" name="barangay" id="barangay" required="true"></select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="street">Street Adress</label>
                            <input type="text" class="form-control" name="street" placeholder="Street Adress"
                                required="true">
                        </div>
                        <div class="form-group col-md-3">

                            <label>Hospital Logo</label>
                            <input name="image" type="file" class="form-control" required="true" autocomplete="off">

                        </div>
                    </div>

                    <h2 class="mt-3 second-h2">HOSPITAL SPECIFIC INFORMATION</h2>

                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="hospital_name">Hospital Street </label>
                            <input name="hospital_street" class="form-control" type="text" placeholder="Hospital Street"
                                required="true">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="level">Hospital Plus Code</label>
                            <select class="form-control select" name="hospital_plus_code" id="level" required="true">
                                <option disabled selected>Select Hospital Plus Code</option>
                                <option value="137403009">137403009</option>
                                <option value="041005009">041005009</option>
                                <option value="021506047">021506047</option>
                                <option value="137405021">137405021</option>
                                <option value="129804009">129804009</option>
                                <option value="133905003">133905003</option>
                                <option value="137404022">137404022</option>
                                <option value="137404035">137404035</option>
                                <option value="112402174">112402174</option>
                                <option value="015518003">015518003</option>
                                <option value="050506012">050506012</option>
                                <option value="137401008">137401008</option>

                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="hospital_name">Hospital Email</label>
                            <input name="hospital_email" class="form-control" type="text" placeholder="Hospital Email"
                                required="true">
                        </div>

                        <div class="form-group col-md-3">
                            <label for="hospital_contact">Hospital Contact no:</label>
                            <input name="hospital_contact" class="form-control" type="text"
                                placeholder="Hospital Contact no:" required="true">
                        </div>
                    </div>

                    <h2 class="mt-3 second-h2">HOSPITAL EQUIPMENTS</h2>


                    <div class="form-row" id="equipmentContainer">
                        <!-- Initial dropdown -->
                        <div class="form-group col-md-3">
                            <label for="hospital-equipment">Oncologists Medical Equipment 1</label>
                            <div class="input-group">
                                <select name="hospital_equipment[]" class="form-control" required="true">
                                    <option value="" disabled selected>Select Medical Equipment</option>
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
                    <div class="submit-section">
                        <button type="button" class="btn btn-primary add-equipment-btn">Add Equipment Form</button>
                        <button type="button" id="clearForm" class="btn btn-secondary clear-form-btn">Clear Equipments
                            Form</button>
                    </div>
                    <div class="submit-section">
                        <button type="submit" name="submit" class="btn btn-primary submit-btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
//idea ng function na to is when user selected the level of hospital meron katumbas na institution leve and speciallevel yung
//hospital nayon
$(document).ready(function() {
    $('#level').on('change', function() {
        var selectedLevel = $(this).val();
        var institutionField = $('#institutionFieldLevel3 select');
        var specialtyField = $('#specialtyField select');

        institutionField.empty(); // Clear previous options
        specialtyField.empty(); // Clear previous options

        // Populate options based on selected level
        if (selectedLevel === 'Non Hospital') {
            institutionField.append('<option disabled selected>Select Hospital Category</option>');
            institutionField.append(
                '<option value="Primary Cancer Control and Clinic (PCCPC)">Primary Cancer Control and Clinic (PCCPC)</option>'
            );
            specialtyField.append('<option disabled selected>Select Hospital Specialty</option>');
            specialtyField.append('<option value="N/A">N/A</option>');
        } else if (selectedLevel === 'Level 1 General Hospital') {
            institutionField.append('<option disabled selected>Select Hospital Category</option>');
            institutionField.append(
                '<option value="Secondary Cancer Control Clinic (SCCC)">Secondary Cancer Control Clinic (SCCC)</option>'
            );
            specialtyField.append('<option disabled selected>Select Hospital Specialty</option>');
            specialtyField.append('<option value="N/A">N/A</option>');
        } else if (selectedLevel === 'Level 2 General Hospital') {
            institutionField.append('<option disabled selected>Select Hospital Category</option>');
            institutionField.append(
                '<option value="Cancer Control Unit (CCU)">Cancer Control Unit (CCU)</option>');
            specialtyField.append('<option disabled selected>Select Hospital Specialty</option>');
            specialtyField.append('<option value="N/A">N/A</option>');
        } else if (selectedLevel === 'Level 3 General Hospital') {
            institutionField.append('<option disabled selected>Select Hospital Category</option>');
            institutionField.append(
                '<option value="Advanced Comprehensive Cancer Centers (ACCC)">Advanced Comprehensive Cancer Centers (ACCC)</option>'
            );
            institutionField.append(
                '<option value="Basic Comprehensive Cancer Center (BCCC)">Basic Comprehensive Cancer Center (BCCC)</option>'
            );
            specialtyField.append('<option disabled selected>Select Hospital Specialty</option>');
            specialtyField.append(
                '<option value="Multispecialty Cancer Center (MCC)">Multispecialty Cancer Center (MCC)</option>'
            );
            specialtyField.append(
                '<option value="Specialty Cancer Center (SCC)">Specialty Cancer Center (SCC)</option>'
            );
        }
    });
});
</script>
<script>

</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<!-- PH AUTOMATIC ADDRESS WAG GALIWAN PARANG AWA-->
<script>
$(document).ready(function() {
    // Load Region
    let regionDropdown = $('#region');
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
    $('#region').on('change', function() {
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
    $('#province').on('change', function() {
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
    $('#city').on('change', function() {
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
    // Counter for dynamically generating label
    var counter = 2;

    // Event delegation on the submit section for adding equipment
    $(".submit-section").on("click", ".add-equipment-btn", function() {
        addNewDropdown();
    });

    function addNewDropdown() {
        var newDropdown = '<div class="form-group col-md-3">' +
            '<label for="hospital-equipment">Equipment</label>' +
            '<div class="input-group">' +
            '<select name="hospital_equipment[]" class="form-control" required>' +
            '<option value="" disabled selected>Select Medical Equipment</option>' +
            '<?php
                $query = $dbh->query("SELECT equipment_name FROM repo_equipment_category");
                while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                ?>' +
            '<option value="<?php echo $row['equipment_name']; ?>"><?php echo $row['equipment_name']; ?></option>' +
            '<?php } ?>' +
            '</select>' +
            '<div class="input-group-append">' +
            '<button type="button" class="btn btn-danger remove-equipment-btn">x</button>' +
            '</div>' +
            '</div>' +
            '</div>';

        $("#equipmentContainer").append(newDropdown);

        // Increment the counter for the next label
        counter++;
    }

    // Event delegation for remove-equipment-btn
    $("#equipmentContainer").on("click", ".remove-equipment-btn", function() {
        $(this).closest('.form-group').remove();
    });

    // Clear form function
    $("#clearForm").on("click", function() {
        // Reset all form fields
        $("form")[0].reset();
    });
});
</script>