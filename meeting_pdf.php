<?php
require('fpdf/fpdf.php');
require_once('db_connect.php');

class PDF extends FPDF
{
    private $fontFamily = 'Arial';
    private $fontSize = 12;

    // Page header
    function Header()
    {
        $this->Image('assets/img/logo.png', 10, 6, 30);
        $this->SetFont($this->fontFamily, 'B', 14);
        $this->Cell(80);
        $this->Cell(30, 10, 'MURANGA COUNTY GOVERNMENT', 0, 1, 'C');
        $this->SetFont($this->fontFamily, 'I', 12);
        $this->Cell(0, 10, 'Meeting Minutes', 0, 1, 'C');
        $this->Ln(10);
    }

    // Page footer
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont($this->fontFamily, 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }

    // Method to handle HTML content from CKEditor
    function WriteHTML($html)
    {
        $html = str_replace("\n", ' ', $html);
        $a = preg_split('/<(.*)>/U', $html, -1, PREG_SPLIT_DELIM_CAPTURE);
        foreach ($a as $i => $e) {
            if ($i % 2 == 0) {
                // Text
                $this->Write(5, stripslashes($e));
            } else {
                // Tag
                if ($e[0] == '/') {
                    $this->CloseTag(strtoupper(substr($e, 1)));
                } else {
                    // Extract tag and attributes
                    $a2 = explode(' ', $e);
                    $tag = strtoupper(array_shift($a2));
                    $attr = [];
                    foreach ($a2 as $v) {
                        if (preg_match('/([^=]*)=["\']?([^"\']*)/', $v, $a3)) {
                            $attr[strtoupper($a3[1])] = $a3[2];
                        }
                    }
                    $this->OpenTag($tag, $attr);
                }
            }
        }
    }

    function OpenTag($tag, $attr)
    {
        // Handling opening tags
        if ($tag == 'B' || $tag == 'I' || $tag == 'U' || $tag == 'STRONG' || $tag == 'INS') {
            $this->SetStyle($tag, true);
        } elseif ($tag == 'P') {
            $this->Ln(10); // Add line break for paragraph
        } elseif ($tag == 'LI') {
            $this->Cell(5, 10, chr(149), 0); // Bullet point for list item
        } elseif ($tag == 'UL') {
            $this->Ln(5); // Add small space before unordered list
        } elseif ($tag == 'H1') {
            $this->SetFont($this->fontFamily, 'B', 16);
            $this->Write(5, stripslashes($attr['text']));
            $this->Ln(10);
        } elseif ($tag == 'H2') {
            $this->SetFont($this->fontFamily, 'B', 14);
            $this->Write(5, stripslashes($attr['text']));
            $this->Ln(8);
        } elseif ($tag == 'H3') {
            $this->SetFont($this->fontFamily, 'B', 12);
            $this->Write(5, stripslashes($attr['text']));
            $this->Ln(6);
        } elseif ($tag == 'U') {
            // Underline text
            $this->SetStyle('U', true);
        } elseif ($tag == 'TABLE') {
            // Start table
            $this->SetFont($this->fontFamily, '', $this->fontSize);
        } elseif ($tag == 'TR') {
            // Start table row
            $this->Ln(6);
        } elseif ($tag == 'TD') {
            // Start table cell
            $this->SetFont($this->fontFamily, '', $this->fontSize);
            $this->Cell(40, 10, stripslashes($attr['text']), 1);
        }
    }

    function CloseTag($tag)
    {
        // Handling closing tags
        if ($tag == 'B' || $tag == 'I' || $tag == 'U' || $tag == 'STRONG' || $tag == 'INS') {
            $this->SetStyle($tag, false);
        } elseif ($tag == 'UL') {
            $this->Ln(5); // Space after unordered list
        }
    }

    function SetStyle($tag, $enable)
    {
        // Apply bold, italic, underline, strong, and inserted text styles
        if ($tag == 'B' || $tag == 'STRONG') {
            $this->SetFont($this->fontFamily, $enable ? 'B' : '');
        } elseif ($tag == 'I') {
            $this->SetFont($this->fontFamily, $enable ? 'I' : '');
        } elseif ($tag == 'U') {
            $this->SetFont($this->fontFamily, $enable ? 'U' : '');
        } elseif ($tag == 'INS') {
            // Handle inserted text if needed, usually similar to underline
            $this->SetFont($this->fontFamily, $enable ? 'U' : '');
        }
    }

    // Define the LoadData() method
    function LoadData($id)
    {
        global $conn; // Use the global database connection
        $stmt = $conn->prepare("SELECT * FROM meetings WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc(); // Return meeting data as an associative array
        } else {
            return false; // No data found for the provided ID
        }
    }

    // Create a table for structured content
    function CreateTable($data)
    {
        $this->SetFont($this->fontFamily, '', $this->fontSize);
        $this->SetXY(10, 50);

        // Title (Bold & Underlined)
        $title = $data['title'];
        $this->SetFont($this->fontFamily, 'B', 14);
        $this->Cell(0, 10, $title, 0, 1, 'C');
        $this->Ln(5);

        // Agenda
        $this->SectionHeader('Agenda');
        $this->SetFont($this->fontFamily, '', 12);
        $this->WriteHTML($data['agenda']);  // Parse and display CKEditor content
        $this->Ln(10);

        // Members Absent
        $this->SectionHeader('Members Absent');
        $this->SetFont($this->fontFamily, '', 12);
        $this->WriteHTML($data['absent']);
        $this->Ln(10);

        // Members Present
        $this->SectionHeader('Members Present');
        $this->SetFont($this->fontFamily, '', 12);
        $this->WriteHTML($data['attendees']);
        $this->Ln(10);

        // Content
        $this->SectionHeader('Content');
        $this->SetFont($this->fontFamily, '', 12);
        $this->WriteHTML($data['content']);
        $this->Ln(10);
    }

    // Utility function for creating section headers
    function SectionHeader($headerTitle)
    {
        $this->SetFont($this->fontFamily, 'B', 12);
        $this->Cell(0, 10, $headerTitle, 0, 1, 'L');
        $this->Ln(2);
    }
}

// Check if the meeting ID is provided in the URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Generate PDF
    $pdf = new PDF();
    $pdf->AddPage();

    // Load data from the database using the meeting ID
    $data = $pdf->LoadData($id);

    if ($data) {
        $pdf->CreateTable($data);
        ob_clean(); // Clean any previous output
        $pdf->Output('D', 'minutes_' . $id . '.pdf'); // Download the generated PDF
    } else {
        ob_clean();
        echo 'No meeting found with the provided ID.';
    }
} else {
    ob_clean();
    echo 'Invalid request. Meeting ID not provided.';
}
?>
