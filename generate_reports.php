<?php
session_start();
include("data_class.php"); // this file extends db.php and sets PDO connection

// Session check
if (!isset($_SESSION['user_id'])|| $_SESSION['user_role'] != 'admin') {
    header("Location: home.php");
    exit();
}

// FPDF include
require('fpdf/fpdf.php');

// Create connection object
$u = new data();
$u->setconnection();  // initialize PDO connection
$conn = $u->getconnection();  // get PDO object

// Validate report type
if (isset($_GET['type'])) {
    $type = $_GET['type'];

    switch ($type) {
        case 'issued_books':
            $title = "Issued Books Report";
            $query = "SELECT * FROM issuebook";
            break;

        case 'returned_books':
            $title = "Returned Books Report";
            $query = "SELECT * FROM issuebook WHERE fine = 0";
            break;

        case 'overdue_books':
            $title = "Overdue Books Report";
            $query = "SELECT * FROM issuebook WHERE issuereturn < CURDATE() AND fine > 0";
            break;

        case 'fine_report':
            $title = "Fine Report";
            $query = "SELECT * FROM issuebook WHERE fine > 0";
            break;

        default:
            die("Invalid report type.");
    }

    $stmt = $conn->query($query);

    echo "<pre>";
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    print_r($data);
    exit();

    // Generate PDF
    $pdf = new FPDF();
    $pdf->AddPage();
   $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(190, 10, $title, 0, 1, 'C');
    $pdf->Ln(10);

    // Table headers
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(30, 10, 'User ID', 1);
    $pdf->Cell(50, 10, 'Book', 1);
    $pdf->Cell(30, 10, 'Issue Date', 1);
    $pdf->Cell(30, 10, 'Return Date', 1);
    $pdf->Cell(20, 10, 'Fine', 1);
    $pdf->Ln();

    $pdf->SetFont('Arial', '', 11);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $pdf->Cell(30, 10, $row['userid'], 1);
        $pdf->Cell(50, 10, $row['issuebook'], 1);
        $pdf->Cell(30, 10, $row['issuedate'], 1);
        $pdf->Cell(30, 10, $row['issuereturn'], 1);
        $pdf->Cell(20, 10, "₹" . $row['fine'], 1);
        $pdf->Ln();
    }

    $pdf->Output();
    exit();
}
?>