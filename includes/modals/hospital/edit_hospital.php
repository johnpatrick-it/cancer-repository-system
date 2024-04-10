<?php
include_once("config.php");

// Redirect to login page if user is not authenticated
if (!isset($_SESSION['admin_id']) || empty($_SESSION['admin_id'])) {
    header('Location: /login.php');
    exit;
}

// Fetch hospital data based on hospital ID
$hospitalId = $_GET['hospital_id'] ?? ''; // Assuming you're passing hospital_id via GET parameter
if (!empty($hospitalId)) {
    $query = "SELECT * FROM hospital_general_information WHERE hospital_id = $1";
    $result = pg_prepare($db_connection, "fetch_hospital", $query);

    if ($result) {
        $result_exec = pg_execute($db_connection, "fetch_hospital", array($hospitalId));
        if ($result_exec) {
            $hospitalData = pg_fetch_assoc($result_exec);
            if ($hospitalData) {
                // Extract hospital data
                    $hospitalName = $hospitalData['hospital_name'];
                    $hospitalLevel = $hospitalData['hospital_level'];
                    $typeOfInstitution = $hospitalData['type_of_institution'];
                    $hospitalBarangay = $hospitalData['hospital_barangay'];
                    $hospitalStreet = $hospitalData['hospital_street'];
                    $specialty = $hospitalData['specialty'];
                // Similarly extract other fields and populate them
            } else {
                echo "Hospital data not found.";
                exit;
            }
        } else {
            echo "Error executing query to fetch hospital data.";
            exit;
        }
    } else {
        echo "Error preparing query to fetch hospital data.";
        exit;
    }
}
?>
<div id="edit_hospital" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <!-- Modal header -->
            <div class="modal-header">
                <h5 class="modal-title">Edit Hospital</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form method="POST" action="/includes/modals/hospital/save_hospital.php" enctype="multipart/form-data" autocomplete="off">
                    <!-- Hospital Information Section -->
                    <h2>HOSPITAL INFORMATION</h2>
                    <div class="form-row">
                        <!-- Hospital Name -->
                        <div class="form-group col-md-3">
                            <label for="hospital_name">Hospital Name</label>
                            <input name="hospital_name" class="form-control" type="text" placeholder="Hospital Name" required value="<?php echo isset($hospitalName) ? htmlspecialchars($hospitalName) : ''; ?>">
                        </div>
                        <!-- Hospital Level -->
                        <div class="form-group col-md-3">
                            <label for="level">Hospital Level</label>
                            <select class="form-control select" name="level" id="level" required>
                                <option value="" disabled>Select Level</option>
                                <!-- Options for hospital level -->
                                <?php
                                $hospitalLevels = array(
                                    "Non Hospital",
                                    "Level 1 General Hospital",
                                    "Level 2 General Hospital",
                                    "Level 3 General Hospital"
                                );
                                foreach ($hospitalLevels as $level) {
                                    $selected = ($level === $hospitalLevel) ? 'selected' : '';
                                    echo "<option value='$level' $selected>$level</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-3" id="institutionFieldLevel3">   
                            <label for="institution">Hospital Category</label>
                            <select class="form-control select" name="institution_level3" required="true">
                                <option disabled selected>Select Hospital Category</option>
                                <?php
                                // Fetch hospital categories from the database and generate <option> tags
                                $hospitalCategories = array(
                                    "Primary Cancer Control and Clinic (PCCPC)",
                                    "Secondary Cancer Control Clinic (SCCC)",
                                    "Cancer Control Unit (CCU)",
                                    "Advanced Comprehensive Cancer Centers (ACCC)",
                                    "Basic Comprehensive Cancer Center (BCCC)"
                                );
                                foreach ($hospitalCategories as $category) {
                                    $selected = ($category === $typeOfInstitution) ? 'selected' : '';
                                    echo "<option value='$category' $selected>$category</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-3" id="specialtyField">
                            <label for="specialty">Specialty</label>
                            <select class="form-control select" name="specialty" required="true">
                                <option disabled selected>Select Hospital Specialty</option>
                                <?php
                                // Fetch hospital specialties from the database and generate <option> tags
                                $hospitalSpecialties = array(
                                    "Multispecialty Cancer Center (MCC)",
                                    "Specialty Cancer Center (SCC)",
                                    // Add more specialties as needed
                                );
                                foreach ($hospitalSpecialties as $specialty) {
                                    // Check if the fetched specialty matches the one from the database
                                    $selected = ($specialty === $specialty) ? 'selected' : '';
                                    echo "<option value='$specialty' $selected>$specialty</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="region">Region</label>
                            <select class="form-control select" name="region" id="region" required="true">
                                <option disabled selected>Select Region</option>
                                <?php
                                // Fetch regions from the database and generate <option> tags
                                $query = "SELECT * FROM regions"; // Replace 'regions' with your actual table name
                                $result = pg_query($db_connection, $query);

                                if ($result) {
                                    while ($row = pg_fetch_assoc($result)) {
                                        $regionName = $row['region_name'];
                                        $regionCode = $row['region_code'];
                                        $selected = ($regionCode === $hospitalRegion) ? 'selected' : '';
                                        echo "<option value='$regionCode' $selected>$regionName</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="province">Province</label>
                            <select class="form-control select" name="province" id="province" required="true">
                                <option disabled selected>Select Province</option>
                                <?php
                                // Fetch provinces from the database and generate <option> tags
                                $query = "SELECT * FROM provinces WHERE region_code = $1"; // Replace 'provinces' with your actual table name
                                $result = pg_prepare($db_connection, "fetch_provinces", $query);

                                if ($result) {
                                    // Bind the region code parameter
                                    $regionCode = $hospitalRegion; // Assuming $hospitalRegion contains the code of the selected region
                                    $result_exec = pg_execute($db_connection, "fetch_provinces", array($regionCode));

                                    if ($result_exec) {
                                        while ($row = pg_fetch_assoc($result_exec)) {
                                            $provinceName = $row['province_name'];
                                            $provinceCode = $row['province_code'];
                                            // Check if the fetched province matches the one associated with the hospital
                                            $selected = ($provinceCode === $hospitalProvince) ? 'selected' : '';
                                            echo "<option value='$provinceCode' $selected>$provinceName</option>";
                                        }
                                    } else {
                                        // Error executing query
                                        echo "<option disabled>Error fetching provinces</option>";
                                    }
                                } else {
                                    // Error preparing query
                                    echo "<option disabled>Error preparing fetch query</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="city">City/Municipality</label>
                            <select class="form-control select" name="city" id="city" required="true">
                                <option disabled selected>Select City/Municipality</option>
                                <?php
                                // Fetch cities/municipalities from the database and generate <option> tags
                                $query = "SELECT * FROM cities WHERE province_code = $1"; // Replace 'cities' with your actual table name
                                $result = pg_prepare($db_connection, "fetch_cities", $query);

                                if ($result) {
                                    // Bind the province code parameter
                                    $provinceCode = $hospitalProvince; // Assuming $hospitalProvince contains the code of the selected province
                                    $result_exec = pg_execute($db_connection, "fetch_cities", array($provinceCode));

                                    if ($result_exec) {
                                        while ($row = pg_fetch_assoc($result_exec)) {
                                            $cityName = $row['city_name'];
                                            $cityCode = $row['city_code'];
                                            // Check if the fetched city matches the one associated with the hospital
                                            $selected = ($cityCode === $hospitalCity) ? 'selected' : '';
                                            echo "<option value='$cityCode' $selected>$cityName</option>";
                                        }
                                    } else {
                                        // Error executing query
                                        echo "<option disabled>Error fetching cities</option>";
                                    }
                                } else {
                                    // Error preparing query
                                    echo "<option disabled>Error preparing fetch query</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="barangay">Barangay</label>
                            <select class="form-control select" name="barangay" id="barangay" required="true">
                                <option disabled selected>Select Barangay</option>
                                <?php
                                // Fetch barangays from the database and generate <option> tags
                                $query = "SELECT * FROM barangays WHERE city_code = $1"; // Replace 'barangays' with your actual table name
                                $result = pg_prepare($db_connection, "fetch_barangays", $query);

                                if ($result) {
                                    // Bind the city code parameter
                                    $cityCode = $hospitalCity; // Assuming $hospitalCity contains the code of the selected city/municipality
                                    $result_exec = pg_execute($db_connection, "fetch_barangays", array($cityCode));

                                    if ($result_exec) {
                                        while ($row = pg_fetch_assoc($result_exec)) {
                                            $barangayName = $row['barangay_name'];
                                            $barangayCode = $row['barangay_code'];
                                            // Check if the fetched barangay matches the one associated with the hospital
                                            $selected = ($barangayCode === $hospitalBarangay) ? 'selected' : '';
                                            echo "<option value='$barangayCode' $selected>$barangayName</option>";
                                        }
                                    } else {
                                        // Error executing query
                                        echo "<option disabled>Error fetching barangays</option>";
                                    }
                                } else {
                                    // Error preparing query
                                    echo "<option disabled>Error preparing fetch query</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="street">Street Address</label>
                            <input type="text" class="form-control" name="street" placeholder="Street Address" required="true">
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
                                        // Query the database to fetch medical equipment options
                                        $query = $dbh->query("SELECT equipment_name FROM repo_equipment_category");
                                        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                    <!-- Populate dropdown options dynamically -->
                                    <option value="<?php echo $row['equipment_name']; ?>">
                                        <?php echo $row['equipment_name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="submit-section">
                        <button type="button" class="btn btn-primary add-equipment-btn">Add Equipment Form</button>
                        <button type="button" id="clearForm" class="btn btn-secondary clear-form-btn">Clear Equipments Form</button>
                    </div>
                    <div class="submit-section">
                        <button type="submit" name="submit" class="btn btn-primary submit-btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- PH AUTOMATIC ADDRESS WAG GALIWAN PARANG AWA-->
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
                institutionField.append('<option value="Primary Cancer Control and Clinic (PCCPC)">Primary Cancer Control and Clinic (PCCPC)</option>');
                specialtyField.append('<option disabled selected>Select Hospital Specialty</option>');
                specialtyField.append('<option value="N/A">N/A</option>');
            } else if (selectedLevel === 'Level 1 General Hospital') {
                institutionField.append('<option disabled selected>Select Hospital Category</option>');
                institutionField.append('<option value="Secondary Cancer Control Clinic (SCCC)">Secondary Cancer Control Clinic (SCCC)</option>');
                specialtyField.append('<option disabled selected>Select Hospital Specialty</option>');
                specialtyField.append('<option value="N/A">N/A</option>');
            } else if (selectedLevel === 'Level 2 General Hospital') {
                institutionField.append('<option disabled selected>Select Hospital Category</option>');
                institutionField.append('<option value="Cancer Control Unit (CCU)">Cancer Control Unit (CCU)</option>');
                specialtyField.append('<option disabled selected>Select Hospital Specialty</option>');
                specialtyField.append('<option value="N/A">N/A</option>');
            } else if (selectedLevel === 'Level 3 General Hospital') {
                institutionField.append('<option disabled selected>Select Hospital Category</option>');
                institutionField.append('<option value="Advanced Comprehensive Cancer Centers (ACCC)">Advanced Comprehensive Cancer Centers (ACCC)</option>');
                institutionField.append('<option value="Basic Comprehensive Cancer Center (BCCC)">Basic Comprehensive Cancer Center (BCCC)</option>');
                specialtyField.append('<option disabled selected>Select Hospital Specialty</option>');
                specialtyField.append('<option value="Multispecialty Cancer Center (MCC)">Multispecialty Cancer Center (MCC)</option>');
                specialtyField.append('<option value="Specialty Cancer Center (SCC)">Specialty Cancer Center (SCC)</option>');
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



<!-- Add the necessary JavaScript libraries -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@latest"></script>