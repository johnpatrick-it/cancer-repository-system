<?php
include('includes/config.php');
require('fpdf186/fpdf.php'); // Include the FPDF library

// Check if the button is clicked
if (isset($_POST['generate_pdf'])) {
    // Fetch data from the database (replace with your actual database connection code)
    $query = "SELECT * FROM patient_data WHERE address_region = 'NCR'";
    $result = pg_query($db_connection, $query);

    // Check if query was successful
    if ($result) {
        // Initialize PDF
        $pdf = new FPDF();
        $pdf->AddPage();

        // Set font
        $pdf->SetFont('Arial','B',16);

        // Add a title
        $pdf->Cell(0,10,'Patient Data for NCR',0,1,'C');

        // Add column headers
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(20,10,'Patient ID',1,0,'C');
        $pdf->Cell(40,10,'Patient Name',1,0,'C');
        $pdf->Cell(30,10,'Address Region',1,0,'C');
        $pdf->Cell(22,10,'Primary Site',1,0,'C');
        $pdf->Cell(22,10,'Cancer Stage',1,0,'C');
        $pdf->Cell(30,10,'Patient Treatment',1,0,'C');
        $pdf->Cell(22,10,'Patient Status',1,1,'C');

        // Set font for data
        $pdf->SetFont('Arial','',8);

        // Fetch data and add to PDF
        while ($row = pg_fetch_assoc($result)) {
          
            $pdf->Cell(20,10,$row['patient_id'],1,0,'C');
            $pdf->Cell(40,10,$row['patient_name'],1,0,'C');
            $pdf->Cell(30,10,$row['address_region'],1,0,'C');
            $pdf->Cell(22,10,$row['primary_site'],1,0,'C');
            $pdf->Cell(22,10,$row['cancer_stage'],1,0,'C');
            $pdf->Cell(30,10,$row['patient_treatment'],1,0,'C');
            $pdf->Cell(22,10,$row['patient_status'],1,1,'C');
        }

        // Output PDF content
        $pdf->Output('D', 'patient_data.pdf'); // 'D' option forces download
        exit;
    } else {
        // Handle query error
        echo "Error: " . pg_last_error($db_connection);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Export</title>
</head>

<body>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <button type="submit" name="generate_pdf">Export Data as PDF</button>
    </form>
</body>

</html>