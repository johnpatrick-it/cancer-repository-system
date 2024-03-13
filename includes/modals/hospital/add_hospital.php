<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');

if (!isset($_SESSION['admin_id']) || empty($_SESSION['admin_id'])) {
    // Redirect to the login page
    header("Location: login.php");
    exit; 
}

$AdminID = $_SESSION['admin_id'] ?? '';

$host = "user=postgres.tcfwwoixwmnbwfnzchbn password=sbit4e-4thyear-capstone-2023 host=aws-0-ap-southeast-1.pooler.supabase.com port=5432 dbname=postgres";
                                            
try {
    $dbh = new PDO("pgsql:" . $host);
    
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}


if (isset($_POST['submit'])) {
    $hospitalName = isset($_POST['hospital_name']) ? $_POST['hospital_name'] : '';
    $hospitalEquipment = isset($_POST['hospital_equipment']) ? $_POST['hospital_equipment'] : [];

	$hospitalLevel = $_POST['level'];
    $institution = $_POST['institution'];
    $region = $_POST['region'];
    $province = $_POST['province'];
    $city = $_POST['city'];
    $barangay = $_POST['barangay'];
    $street = $_POST['street'];

	$admin_user_id = $AdminID;

    if (isset($_FILES['image'])) {
        $image = $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], './uploads/'.$image);
        $location = $image;
        
    } else {
        echo "No file uploaded or the 'image' key is not set in the \$_FILES array.";
    }

    // Ensure $hospitalEquipment is an array
    if (!is_array($hospitalEquipment)) {
        $hospitalEquipment = [$hospitalEquipment];
    }

    foreach ($hospitalEquipment as $equipment) {
		$sql = "INSERT INTO hospital_general_information 
				(admin_id, hospital_equipments, hospital_name, hospital_level, type_of_institution, hospital_region, hospital_province, hospital_city, hospital_barangay, hospital_street, location)
				VALUES
				(:admin_id, :equipment_name, :hospital_name, :hospital_level, :type_of_institution, :hospital_region, :hospital_province, :hospital_city, :hospital_barangay, :hospital_street, :location)";
	
		$stmt = $dbh->prepare($sql);
		$stmt->bindParam(':admin_id', $admin_user_id, PDO::PARAM_INT);
		$stmt->bindParam(':equipment_name', $equipment, PDO::PARAM_STR);
		$stmt->bindParam(':hospital_name', $hospitalName, PDO::PARAM_STR);
		$stmt->bindParam(':hospital_level', $hospitalLevel, PDO::PARAM_STR);
		$stmt->bindParam(':type_of_institution', $institution, PDO::PARAM_STR);
		$stmt->bindParam(':hospital_region', $region, PDO::PARAM_STR);
		$stmt->bindParam(':hospital_province', $province, PDO::PARAM_STR);
		$stmt->bindParam(':hospital_city', $city, PDO::PARAM_STR);
		$stmt->bindParam(':hospital_barangay', $barangay, PDO::PARAM_STR);
		$stmt->bindParam(':hospital_street', $street, PDO::PARAM_STR);
        $stmt->bindParam(':location', $location); // Add this line
	
		if ($stmt->execute()) {
			echo '<script>';
			echo 'Swal.fire("Data inserted successfully!");';
			echo 'window.location.href = "hospital-information.php"';
			echo '</script>';
		} else {
			echo "Error inserting data: " . $stmt->errorInfo()[2] . "\n";
		}
	}

		
		
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
                <form method="POST" action="" enctype="multipart/form-data" autocomplete="off">
                    <h2>HOSPITAL INFORMATION</h2>
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="hospital_name">Hospital Name </label>
                            <input name="hospital_name" class="form-control" type="text" placeholder="Hospital Name"
                                required>
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
                        <div class="form-group col-md-3">
                            <label for="street">Hospital Logo</label>
                            <input name="image" type="file" class="form-control" required="true"
                                                        autocomplete="off">
                        </div>
                    </div>

                    <h2 class="mt-3 second-h2">HOSPITAL EQUIPMENTS</h2>


                    <div class="form-row" id="equipmentContainer">
                        <!-- Initial dropdown -->
                        <div class="form-group col-md-3">
                            <label for="hospital-equipment">Oncologists Medical Equipment 1</label>
                            <div class="input-group">
                                <select name="hospital_equipment[]" class="form-control" required>
                                    <option value="" disabled selected>Select Medical Equipment</option>
                                    <?php
                $query = $dbh->query("SELECT equipment_name FROM repo_equipment_category");
                while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                ?>
                                    <option value="<?php echo $row['equipment_name']; ?>">
                                        <?php echo $row['equipment_name']; ?></option>
                                    <?php } ?>
                                </select>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-primary add-equipment-btn">+</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="submit-section">
                        <button type="submit" name="submit" class="btn btn-primary submit-btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    // Counter for dynamically generating label
    var counter = 2;

    // Event delegation on the equipmentContainer
    $("#equipmentContainer").on("click", ".add-equipment-btn", function() {
        addNewDropdown();
    });

    function addNewDropdown() {
        var newDropdown = '<div class="form-group col-md-3">' +
            '<label for="hospital-equipment"> ' + ' Equipment </label>' + " " + counter +
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
            '<button type="button" class="btn btn-primary add-equipment-btn">+</button>' +
            '</div>' +
            '</div>' +
            '</div>';

        $("#equipmentContainer").append(newDropdown);

        // Increment the counter for the next label
        counter++;
    }
});
</script>



<!-- Include jQuery -->
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