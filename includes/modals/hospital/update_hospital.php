<<<<<<< HEAD
<!-- Add the necessary JavaScript libraries -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@latest"></script>

=======
>>>>>>> b108fa4dc5d6b3645dcc7584571c79bf87a22615
<?php  
include_once("../../../includes/config.php");

function sanitizeString($input) {
    // Remove leading and trailing whitespace
    $input = trim($input);
    // Remove any HTML tags
    $input = strip_tags($input);
    // Return sanitized string
    return $input;
}

// Check if the database connection is established
if ($db_connection) {
    // Sanitize and validate hospital ID
    $hospitalId = isset($_POST['hospital_id']) ? ($_POST['hospital_id']) : '';
    $hospitalId = sanitizeString($hospitalId); // No need for validation for UUIDs

    // Sanitize other input fields
    $hospitalName = isset($_POST['hospital_name']) ? $_POST['hospital_name'] : '';
    $hospitalName = sanitizeString($hospitalName);

    $hospitalLevel = isset($_POST['hospital_level']) ? $_POST['hospital_level'] : '';
    $hospitalLevel = sanitizeString($hospitalLevel);

    $TypeInstitution = isset($_POST['type_institution']) ? $_POST['type_institution'] : '';
    $TypeInstitution = sanitizeString($TypeInstitution);

    $Region = isset($_POST['region']) ? $_POST['region'] : '';
    $Region = sanitizeString($Region);

    $Province = isset($_POST['province']) ? $_POST['province'] : '';
    $Province = sanitizeString($Province);

    $City = isset($_POST['city']) ? $_POST['city'] : '';
    $City = sanitizeString($City);

    $Barangay = isset($_POST['barangay']) ? $_POST['barangay'] : '';
    $Barangay = sanitizeString($Barangay);

    $Street = isset($_POST['street']) ? $_POST['street'] : '';
    $Street = sanitizeString($Street);

    $Equipments = isset($_POST['equipments']) ? $_POST['equipments'] : '';
    $Equipments = sanitizeString($Equipments);

    // Prepare the update statement
    $query = "UPDATE hospital_general_information SET hospital_name = $1, hospital_level = $2, type_of_institution = $3, hospital_region = $4, hospital_province = $5, hospital_city = $6, hospital_barangay = $7, hospital_street = $8, hospital_equipments = $9 WHERE hospital_id = $10";
    $params = array($hospitalName, $hospitalLevel, $TypeInstitution, $Region, $Province, $City, $Barangay, $Street, $Equipments, $hospitalId);
    $result = pg_query_params($db_connection, $query, $params);

    // Check if the query was successful
    if ($result) {
        echo "success";
    } else {
        echo "error: " . pg_last_error($db_connection);
    }

    // Close the connection
    pg_close($db_connection);
} else {
    echo "Database connection not established.";
}
<<<<<<< HEAD
?>
=======
?>
>>>>>>> b108fa4dc5d6b3645dcc7584571c79bf87a22615
