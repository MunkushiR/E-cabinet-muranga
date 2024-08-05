<?php
require('fpdf/fpdf.php');
require_once('db_connect.php');

class PDF extends FPDF
{
    // Page header
    function Header()
    {
        // Logo
        $imagePath = 'assets/img/logo.png';
        $imageWidth = 20; // Set the width of the image
        $imageHeight = 0; // Set the height to 0 to maintain the aspect ratio

        // Get the width of the page
        $pageWidth = $this->GetPageWidth();

        // Calculate the X position to center the image
        $xPosition = ($pageWidth - $imageWidth) / 2;

        // Display the image
        $this->Image($imagePath, $xPosition, 6, $imageWidth, $imageHeight);

        $this->Ln(18); // Move below the image by 30 units (adjust if needed)
        $this->SetFont('Arial', 'B', 12); // Set font
        $this->Cell(0, 10, 'MURANGA COUNTY GOVERNMENT', 0, 1, 'C'); // Add title centered
        $this->Ln(10); // Add extra space after the title if needed
    }

    // Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }

    // Load data
    function LoadData($id)
    {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM `meetings` WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Draw Underlined and Bold Text
    function DrawUnderlinedBoldText($text, $x, $y, $width, $fontSize = 12)
    {
        $this->SetXY($x, $y);
        $this->SetFont('Arial', 'B', $fontSize);
        $this->MultiCell($width, 10, $text, 0, 'L');
        
        // Get current position after drawing text
        $lineY = $this->GetY();
        $this->SetXY($x, $lineY); // Move to the last line of the text
        
        // Draw underline
        $this->Line($x, $lineY + 1, $x + $width, $lineY + 1); // Position the line slightly below the text
    }

    // Table
    function CreateTable($data)
    {
        $this->SetFont('Arial', '', 10);
        
        $this->SetXY(10, 50); // Set position where you want the title to start
        
        // Title and underline
        $title = '' . $data['title'];
        $pageWidth = $this->GetPageWidth();
        $margin = 10; // Margin from the left
        $availableWidth = $pageWidth - 2 * $margin; // Available width for title

        // Draw the title and underline
        $this->DrawUnderlinedBoldText($title, $margin, $this->GetY(), $availableWidth);
        
        // Move to the next line for type and other content
        $this->Ln(10); // Adjust spacing as needed

        // Type and underline
        $type = 'Type: ' . $data['type'];
        $this->DrawUnderlinedBoldText($type, $margin, $this->GetY(), $availableWidth);
        
        // Move to the next line for other content
        $this->Ln(10); // Adjust spacing as needed

        // Continue with the rest of the table content
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(50, 10, 'Date:', 0, 0);
        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 10, $data['date'], 0, 1);
      
        // Assume $data['time'] is in 24-hour format (e.g., "14:30")
        $time_24 = $data['time'];
        
        // Convert 24-hour format to 12-hour format with AM/PM
        $dateTime = new DateTime($time_24);
        $time_am_pm = $dateTime->format('h:i A');
        
        // Use FPDF to display the formatted time
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(50, 10, 'Time:', 0, 0);
        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 10, $time_am_pm, 0, 1);
        $this->Ln(10);
    
        

        $this->SetFont('Arial', 'B', 10);
        $this->Cell(0, 10, 'Agenda', 0, 1, 'L');
        $this->SetFont('Arial', '', 10);
        $this->MultiCell(0, 10, $data['agenda']);
        $this->Ln(10);

        $this->SetFont('Arial', 'B', 10);
        $this->Cell(0, 10, 'Members Absent', 0, 1, 'L');
        $this->SetFont('Arial', '', 10);
        $this->MultiCell(0, 10, $data['absent']);
        $this->Ln(10);

        $this->SetFont('Arial', 'B', 10);
        $this->Cell(0, 10, 'Members Present', 0, 1, 'L');
        $this->SetFont('Arial', '', 10);
        $this->MultiCell(0, 10, $data['attendees']);
        $this->Ln(10);

        $this->SetFont('Arial', 'B', 10);
        $this->Cell(0, 10, 'Absent With Apology', 0, 1, 'L');
        $this->SetFont('Arial', '', 10);
        $this->MultiCell(0, 10, $data['absent']);
        $this->Ln(10);

        $this->SetFont('Arial', 'B', 10);
        $this->Cell(0, 10, 'Content', 0, 1, 'L');
        $this->SetFont('Arial', '', 9);
        $this->MultiCell(0, 10, $data['content']);

       $this->SetFont('Arial', 'B', 10);
$this->Cell(30, 10, 'Signed by:', 0, 0, 'L'); // Label "Signed by" with a fixed width

$this->SetFont('Arial', '', 10);
$this->Cell(0, 10, $data['signed_by'], 0, 1, 'L'); // Signer's name, stretching to the end of the line

$this->Ln(10); // Move to the next line with some space after

    }
}

// Get the meeting ID from the URL
$id = isset($_GET['id']) ? intval($_GET['id']) : die("Meeting ID not provided.");

$pdf = new PDF();
$pdf->AddPage();
$data = $pdf->LoadData($id);
$pdf->CreateTable($data);
$pdf->Output('D', 'minutes_' . $id . '.pdf'); // 'I' for inline view, 'D' for download

$conn->close();
?>
