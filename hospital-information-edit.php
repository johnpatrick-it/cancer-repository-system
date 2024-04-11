<?php
session_start();
include_once("includes/config.php");

// Check if user is logged in
if (!isset($_SESSION['admin_id']) || empty($_SESSION['admin_id'])) {
    header('Location: /login.php');
    exit;
}

// Ensure hospital_id is provided in the URL
if (!isset($_GET['hospital_id']) || empty($_GET['hospital_id'])) {
    // Redirect if hospital_id is not provided
    header('Location: /'); // Redirect to home page or any other appropriate page
    exit;
}

// Fetch hospital_id from URL
$hospital_id = $_GET['hospital_id'];

// Connect to PostgreSQL database
$conn = pg_connect($host);

if (!$conn) {
    echo "Failed to connect to PostgreSQL";
    exit;
}

// Prepare SQL statement to fetch hospital data
$query = "SELECT hospital_name, hospital_level, type_of_institution, hospital_barangay, hospital_street, specialty FROM hospital_general_information WHERE hospital_id = $1";
$params = array($hospital_id);

// Execute the query with parameters
$result = pg_query_params($conn, $query, $params);

if (!$result) {
    echo "Error in SQL query";
    exit;
}

// Check if hospital data is found
if (pg_num_rows($result) > 0) {
    // Fetch the hospital data
    $hospitalData = pg_fetch_assoc($result);

    // Extract fetched hospital data into variables
    $hospitalName = $hospitalData['hospital_name'];
    $hospitalLevel = $hospitalData['hospital_level'];
    $typeOfInstitution = $hospitalData['type_of_institution'];
    $hospitalBarangay = $hospitalData['hospital_barangay'];
    $hospitalStreet = $hospitalData['hospital_street'];
    $specialty = $hospitalData['specialty'];
} else {
    // Redirect if hospital data is not found
    header('Location: /'); // Redirect to home page or any other appropriate page
    exit;
}

// Close connection
pg_close($conn);
// Fetch regions from the database
$query = "SELECT * FROM regions"; // Replace 'regions' with your actual table name
$regions = []; // Fetch regions and store them in this array

// Fetch provinces from the database based on region_code
$query = "SELECT * FROM provinces WHERE region_code = ?"; // Replace 'provinces' with your actual table name
$provinces = []; // Fetch provinces and store them in this array

// Fetch cities/municipalities from the database based on province_code
$query = "SELECT * FROM cities WHERE province_code = ?"; // Replace 'cities' with your actual table name
$cities = []; // Fetch cities/municipalities and store them in this array

// Fetch barangays from the database based on city_code
$query = "SELECT * FROM barangays WHERE city_code = ?"; // Replace 'barangays' with your actual table name
$barangays = []; // Fetch barangays and store them in this array
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Hospital Information</title>
    <!-- Include SweetAlert2 library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="assets/js/addressSelector.js"></script>
    <style>
        h2 {
            font-size: 1rem;
            margin-bottom: 1rem;
        }

        .second-h2 {
            border-top: 1px solid grey;
            padding-top: 10px;
        }
                /* Body styles */
                body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        /* Form container styles */
        .form-container {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
        }
        /* Form input styles */
        .form-group label {
            font-weight: bold;
        }
        .form-control {
            border-radius: 5px;
            margin-bottom: 15px;
        }
        /* Button styles */
        .btn-primary {
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            color: #fff;
            cursor: pointer;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }

    </style>
</head>
<body>
<div id="add_hospital" class="modal custom-modal fade " role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Hospital</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="/includes/modals/hospital/save_hospital.php" enctype="multipart/form-data"
                      autocomplete="off">
                    <h2>HOSPITAL INFORMATION</h2>
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="hospital_name">Hospital Name </label>
                            <input name="hospital_name" class="form-control" type="text" placeholder="Hospital Name"
                                   required="true" value="<?php echo htmlspecialchars($hospitalName); ?>">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="level">Hospital Level</label>
                            <select class="form-control select" name="level" id="level" required="true">
                                <option disabled selected>Select Level</option>
                                <option value="Non Hospital" <?php if ($hospitalLevel === 'Non Hospital') echo 'selected'; ?>>
                                    Non-Hospital
                                </option>
                                <option value="Level 1 General Hospital" <?php if ($hospitalLevel === 'Level 1 General Hospital') echo 'selected'; ?>>
                                    Level 1 General Hospital
                                </option>
                                <option value="Level 2 General Hospital" <?php if ($hospitalLevel === 'Level 2 General Hospital') echo 'selected'; ?>>
                                    Level 2 General Hospital
                                </option>
                                <option value="Level 3 General Hospital" <?php if ($hospitalLevel === 'Level 3 General Hospital') echo 'selected'; ?>>
                                    Level 3 General Hospital
                                </option>
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
                            <label for="street">Street Address</label>
                            <input type="text" class="form-control" name="street" placeholder="Street Address"
                                   required="true" value="<?php echo htmlspecialchars($hospitalStreet); ?>">
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

<script>
    //idea ng function na to is when user selected the level of hospital meron katumbas na institution leve and speciallevel yung
    //hospital nayon
    $(document).ready(function () {
        $('#level').on('change', function () {
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
                regionDropdown.append($('<option></option>').attr('value', entry.region_code).text(
                    entry.region_name));
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
                    provinceDropdown.append($('<option></option>').attr('value', entry
                        .province_code).text(entry.province_name));
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
                    cityDropdown.append($('<option></option>').attr('value', entry
                        .city_code).text(entry.city_name));
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
                    barangayDropdown.append($('<option></option>').attr('value', entry
                        .brgy_code).text(entry.brgy_name));
                });
            });
        });
    });
</script>
<script>
    $(document).ready(function () {
        // Counter for dynamically generating label
        var counter = 2;

        // Event delegation on the submit section for adding equipment
        $(".submit-section").on("click", ".add-equipment-btn", function () {
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
        $("#equipmentContainer").on("click", ".remove-equipment-btn", function () {
            $(this).closest('.form-group').remove();
        });

        // Clear form function
        $("#clearForm").on("click", function () {
            // Reset all form fields
            $("form")[0].reset();
        });
    });
</script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>