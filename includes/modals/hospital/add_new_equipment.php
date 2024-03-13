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

$hospital_name_ID = $_SESSION['hospital_name'] ?? '';


$host = "user=postgres.tcfwwoixwmnbwfnzchbn password=sbit4e-4thyear-capstone-2023 host=aws-0-ap-southeast-1.pooler.supabase.com port=5432 dbname=postgres";
                                            
try {
    $dbh = new PDO("pgsql:" . $host);
    
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}


if (isset($_POST['submit'])) {

    $hospitalName = isset($_POST['hospital_name']) ? $_POST['hospital_name'] : '';
    $hospitalEquipment = isset($_POST['hospital_equipment']) ? $_POST['hospital_equipment'] : [];
    $level = isset($_POST['level_hidden']) ? $_POST['level_hidden'] : '';
    $institution = isset($_POST['institution_hidden']) ? $_POST['institution_hidden'] : '';
    $region = isset($_POST['region_hidden']) ? $_POST['region_hidden'] : '';
    $province = isset($_POST['province_hidden']) ? $_POST['province_hidden'] : '';
    $city = isset($_POST['city_hidden']) ? $_POST['city_hidden'] : '';
    $barangay = isset($_POST['barangay_hidden']) ? $_POST['barangay_hidden'] : '';
    $street = isset($_POST['street_hidden']) ? $_POST['street_hidden'] : '';
    
	$admin_user_id = $AdminID;

    // Ensure $hospitalEquipment is an array
    if (!is_array($hospitalEquipment)) {
        $hospitalEquipment = [$hospitalEquipment];
    }

    foreach ($hospitalEquipment as $equipment) {
		$sql = "INSERT INTO hospital_general_information 
				(admin_id, hospital_equipments, hospital_name, hospital_level, type_of_institution, hospital_region, hospital_province, hospital_city, hospital_barangay, hospital_street)
				VALUES
				(:admin_id, :equipment_name, :hospital_name, :hospital_level, :type_of_institution, :hospital_region, :hospital_province, :hospital_city, :hospital_barangay, :hospital_street)";
	
		$stmt = $dbh->prepare($sql);
		$stmt->bindParam(':admin_id', $admin_user_id, PDO::PARAM_INT);
		$stmt->bindParam(':equipment_name', $equipment, PDO::PARAM_STR);
		$stmt->bindParam(':hospital_name', $hospitalName, PDO::PARAM_STR);
		$stmt->bindParam(':hospital_level', $level, PDO::PARAM_STR);
		$stmt->bindParam(':type_of_institution', $institution, PDO::PARAM_STR);
		$stmt->bindParam(':hospital_region', $region, PDO::PARAM_STR);
		$stmt->bindParam(':hospital_province', $province, PDO::PARAM_STR);
		$stmt->bindParam(':hospital_city', $city, PDO::PARAM_STR);
		$stmt->bindParam(':hospital_barangay', $barangay, PDO::PARAM_STR);
		$stmt->bindParam(':hospital_street', $street, PDO::PARAM_STR);
	
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

<div id="add_new_equipment" class="modal custom-modal fade " role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Equipment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="" enctype="multipart/form-data" autocomplete="off">
                    <h2>HOSPITAL INFORMATION</h2>
                    <?php
                 
										$query = $dbh->query("SELECT DISTINCT ON (hospital_name) 
                                        hospital_name, hospital_level, type_of_institution, hospital_barangay, hospital_street, hospital_region,hospital_province,hospital_city
                                FROM hospital_general_information WHERE hospital_name = '$hospital_name'");
										while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                                        
										?>
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="hospital_name">Hospital Name</label>
                            <input name="hospital_name" id="hospital_name" class="form-control" type="text"
                                value="<?php echo $row['hospital_name']; ?>" disabled>
                            <input type="hidden" name="hospital_name" value="<?php echo $row['hospital_name']; ?>">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="level">Hospital Level</label>
                            <input name="level" id="level" class="form-control" type="text"
                                value="<?php echo $row['hospital_level']; ?>" disabled>
                            <input type="hidden" name="level_hidden" value="<?php echo $row['hospital_level']; ?>">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="institution">Hospital Institution</label>
                            <input name="institution" class="form-control" type="text"
                                value="<?php echo $row['type_of_institution']; ?>" disabled>
                            <input type="hidden" name="institution_hidden"
                                value="<?php echo $row['type_of_institution']; ?>">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="region">Region</label>
                            <input name="region" class="form-control" type="text"
                                value="<?php echo $row['hospital_region']; ?>" disabled>
                            <input type="hidden" name="region_hidden" value="<?php echo $row['hospital_region']; ?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="province">Province</label>
                            <input name="province" class="form-control" type="text"
                                value="<?php echo $row['hospital_province']; ?>" disabled>
                            <input type="hidden" name="province_hidden"
                                value="<?php echo $row['hospital_province']; ?>">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="city">City/Municipality</label>
                            <input name="city" class="form-control" type="text"
                                value="<?php echo $row['hospital_city']; ?>" disabled>
                            <input type="hidden" name="city_hidden" value="<?php echo $row['hospital_city']; ?>">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="barangay">Barangay</label>
                            <input name="barangay" class="form-control" type="text"
                                value="<?php echo $row['hospital_barangay']; ?>" disabled>
                            <input type="hidden" name="barangay_hidden"
                                value="<?php echo $row['hospital_barangay']; ?>">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="street">Street Address</label>
                            <input name="street" class="form-control" type="text"
                                value="<?php echo $row['hospital_street']; ?>" disabled>
                            <input type="hidden" name="street_hidden" value="<?php echo $row['hospital_street']; ?>">
                        </div>
                    </div>
                    <?php }?>
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

</script>