<?php
include('includes/auth_check.php');
include('db.php');

// Include FPDF
require('fpdf/fpdf.php');

// Get declaration ID
if(!isset($_GET['id'])){
    die("No declaration ID provided.");
}
$id = intval($_GET['id']);

// Fetch declaration
$stmt = $conn->prepare("SELECT * FROM declarations WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows == 0){
    die("Declaration not found.");
}

$data = $result->fetch_assoc();

// Create PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);

// Header
$pdf->Cell(0,10,'HIGH COURT OF KADUNA STATE',0,1,'C');
$pdf->SetFont('Arial','',14);
$pdf->Cell(0,8,'Age Declaration (H Declaration)',0,1,'C');
$pdf->Ln(5);

// Token
$pdf->SetFont('Arial','',12);
$pdf->Cell(0,8,'Declaration Token: '.$data['qr_token'],0,1,'C');
$pdf->Ln(5);

// Applicant info block
function addField($pdf, $label, $value) {
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(50,8,$label,1);
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(0,8,$value,1,1);
}

addField($pdf, 'Applicant Name:', $data['applicant_name']);
addField($pdf, 'Date of Birth:', $data['dob']);
addField($pdf, 'Gender:', $data['gender']);
addField($pdf, 'LGA:', $data['lga']);
addField($pdf, 'Father\'s Name:', $data['father_fullname']);
addField($pdf, 'Mother\'s Name:', $data['mother_fullname']);
addField($pdf, 'Place of Birth:', $data['place_of_birth']);
addField($pdf, 'State of Origin:', $data['state_of_origin']);
addField($pdf, 'Declarant Name:', $data['declarant_name']);

// **New field: Date of Insurance**
if(!empty($data['date_of_insurance'])){
    addField($pdf, 'Date of Insurance:', $data['date_of_insurance']);
}

// Photo (optional)
if(!empty($data['photo']) && file_exists('uploads/'.$data['photo'])){
    $pdf->Ln(5);
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(0,8,'Photo:',0,1);
    $pdf->Image('uploads/'.$data['photo'], 80, $pdf->GetY(), 50);
}

// Footer note
$pdf->Ln(25);
$pdf->SetFont('Arial','I',10);
$pdf->MultiCell(
    0,
    5,
    "This is an official Age Declaration issued by the High Court of Kaduna State. Verify using the token on the official portal.",
    0,
    'C'
);

// Output PDF
$pdf->Output('I','H_Declaration_'.$data['qr_token'].'.pdf');
?>
