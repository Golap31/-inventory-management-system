<?php
// Include Composer autoload (TCPDF Library)
require_once __DIR__ . '/vendor/autoload.php';

// Include the database connection file
require_once('db/loss_db.php');

// Create instance of TCPDF
$pdf = new TCPDF();
$pdf->AddPage();

// Set title
$pdf->SetFont('helvetica', 'B', 16);
$pdf->Cell(0, 10, 'Full Loss Report', 0, 1, 'C');

// Fetch ALL loss data (no date filter)
$query = "SELECT * FROM loss";
$result = mysqli_query($conn, $query);

// Check if any data exists
if (mysqli_num_rows($result) > 0) {
    // Set font for table
    $pdf->SetFont('helvetica', '', 12);

    // Create table header
    $pdf->Cell(30, 10, 'Product', 1);
    $pdf->Cell(30, 10, 'Loss Type', 1);
    $pdf->Cell(30, 10, 'Stage', 1);
    $pdf->Cell(30, 10, 'Date', 1);
    $pdf->Cell(30, 10, 'Amount', 1);
    $pdf->Ln();

    // Output each row
    while ($row = mysqli_fetch_assoc($result)) {
        $pdf->Cell(30, 10, $row['product_name'], 1);
        $pdf->Cell(30, 10, $row['loss_type'], 1);
        $pdf->Cell(30, 10, $row['stage'], 1);
        $pdf->Cell(30, 10, $row['loss_date'], 1);
        $pdf->Cell(30, 10, $row['lost_amount'] . ' ' . $row['unit'], 1);
        $pdf->Ln();
    }
} else {
    // No data case
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell(0, 10, 'No loss data found.', 0, 1, 'C');
}

// Output the PDF
$pdf->Output('loss_report.pdf', 'I');
?>
