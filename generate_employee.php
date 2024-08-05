<?php
require_once('db_connect.php');
require('fpdf/fpdf.php');

class PDF extends FPDF
{
    function Header()
    {
        // Logo
        $this->Image('assets/img/logo.png', 10, 6, 30); // Adjust the path and dimensions as needed
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, 'Employee Information', 0, 1, 'C');
        $this->Ln(20);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }

    function EmployeeTable($data)
    {
        $this->SetFont('Arial', '', 12);

        // Table header
        $this->SetFillColor(200, 220, 255);
        $this->SetDrawColor(50, 50, 100);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(50, 10, 'Field', 1, 0, 'C', true);
        $this->Cell(0, 10, 'Value', 1, 1, 'C', true);

        // Table body
        $this->SetFont('Arial', '', 12);
        $this->SetFillColor(240, 240, 240);
        $fill = false;
        foreach ($data as $key => $value) {
            $this->Cell(50, 10, ucfirst($key) . ':', 1, 0, 'R', $fill);
            $this->Cell(0, 10, $value, 1, 1, 'L', $fill);
            $fill = !$fill;
        }
        $this->Ln(10); // Add some space between employees
    }
}

// Fetch all employees from the database
$employees = $conn->query("SELECT * FROM employees");

if ($employees && $employees->num_rows > 0) {
    // Create PDF
    $pdf = new PDF();
    $pdf->AddPage();

    while ($meta = $employees->fetch_assoc()) {
        // Fetch the employee data from the database
        $data = array(
            'firstname' => htmlspecialchars($meta['firstname']),
            'lastname' => htmlspecialchars($meta['lastname']),
            'work_id' => htmlspecialchars($meta['work_id']),
            'position' => htmlspecialchars($meta['position']),
            'work_email' => htmlspecialchars($meta['work_email']),
            'phonenumber' => htmlspecialchars($meta['phonenumber'])
        );

        $pdf->EmployeeTable($data);
    }

    $pdf->Output('D', 'employee_information.pdf');
} else {
    echo "No employees found in the database.";
}
?>
