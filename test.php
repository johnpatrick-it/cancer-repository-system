<?php
session_start();

//VERY IMPORTANT DONT ERASE
if (!isset($_SESSION['admin_id']) || empty($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit; 
}

$AdminID = $_SESSION['admin_id'] ?? '';

include('includes/config.php');

$host = "user=postgres.tcfwwoixwmnbwfnzchbn password=sbit4e-4thyear-capstone-2023 host=aws-0-ap-southeast-1.pooler.supabase.com port=5432 dbname=postgres";
                                            
try {
    $dbh = new PDO("pgsql:" . $host);
    
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}


?>
<table class="data-table table stripe hover nowrap" id="imformationTable">
    <thead>
        <tr>

            <th class="searchable">IMG</th>

            <th>ACTION</th>
        </tr>
    </thead>
    <tbody>
        <?php 
                                          
                                              $host = "host=aws-0-ap-southeast-1.pooler.supabase.com port=5432 dbname=postgres user=postgres.tcfwwoixwmnbwfnzchbn password=sbit4e-4thyear-capstone-2023";
                                                try {
                                                    // Create a new PDO instance
                                                    $dbh = new PDO("pgsql:" . $host);
                                                } catch (PDOException $e) {
                                                    echo "Connection failed: " . $e->getMessage();
                                                    exit; // Stop execution if unable to connect to the database
                                                }

                                                    $query = "SELECT image_data FROM hospital_general_information";
                                                    $stmt = $dbh->prepare($query);
                                                    $stmt->execute();

                                                    // Fetch all results
                                                    $results = $stmt->fetchAll(PDO::FETCH_OBJ);

                                                                        // Check if any images are found
                                                    if ($results) {
                                                    $cnt = 1;
                                                    // Display the images within a table
                                                    foreach ($results as $result) {
                                                        // Get the image data
                                                        $imageData = $result->image_data;

                                                // Check if image data is empty or null
                                                if ($imageData) {
                                                    // Convert the image data to base64 encoding
                                                    $base64Image = base64_encode(stream_get_contents($imageData));

                                                    // Display the image within a table row
                                                    echo '<tr>';
                                                 
                                                    echo '<td><img src="data:image/jpeg;base64,' . $base64Image . '" alt="Equipment Image" class="equipment-image"></td>';
                                                  
                                                                                   
                                                                                echo '</tr>';
                                                                                
                                                                                
                                                                               $cnt++;
                                                                            } else {
                                                                                echo "<tr><td colspan='6'>Image data is empty or null.</td></tr>";
                                                                            }
                                                                        }
                                                                    } else {
                                                                        echo "<tr><td colspan='6'>No images found.</td></tr>";
                                                                    }
                                                                    ?>
    </tbody>
</table>