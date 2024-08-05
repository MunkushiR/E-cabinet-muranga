<?php
require_once('db_connect.php');
require('fpdf/fpdf.php');

class PDF extends FPDF
{
    // Page header
    function Header()
    {
        $this->SetFont('Arial', 'B', 12);

        // Logo
        $this->Image('assets/img/logo.png', 10, 10, 30); // Adjust the path and dimensions as needed

        // Company Name
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, 'Employee Attendance list', 0, 1, 'C'); // Add company name
        $this->Ln(5);

        // Title
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 10, 'Attendance List', 0, 1, 'C');
        $this->Ln(10);
    }

    // Page footer
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    // Table
    function AttendanceTable($header, $data)
    {
        // Column widths
        $w = array(50, 40); // Adjust column widths for vertical format
        
        // Header
        $this->SetFont('Arial', 'B', 12);
        $this->SetFillColor(200, 220, 255); // Background color for header
        foreach ($header as $i => $title) {
            $this->Cell($w[0], 10, $title, 1, 0, 'C', true);
        }
        $this->Ln();

        // Data
        $this->SetFont('Arial', '', 10);
        $this->SetFillColor(240, 240, 240); // Background color for rows
        $fill = false;
        foreach ($data as $row) {
            $this->Cell($w[0], 10, 'Date: ' . date("M d, Y", strtotime($row['date'])), 1, 0, 'L', $fill);
            $this->Cell($w[0], 10, 'Work ID: ' . $row['work_id'], 1, 0, 'L', $fill);
            $this->Cell($w[0], 10, 'Name: ' . $row['name'], 1, 0, 'L', $fill);
            $this->Ln();
            $this->MultiCell($w[1] * 2, 10, 'Time Record: ' . $row['time_record'], 1, 'L', $fill); // MultiCell for multiple lines
            $fill = !$fill;
        }
    }
}

// Get the attendance data
$att = $conn->query("SELECT a.*, e.work_id, concat(e.lastname, ', ', e.firstname) as ename FROM attendance a INNER JOIN employees e ON a.employee_id = e.id ORDER BY UNIX_TIMESTAMP(datetime_log) ASC") or die(mysqli_error());
$lt_arr = array(1 => "Time-in AM", 2 => "Time-out AM", 3 => "Time-in PM", 4 => "Time-out PM");

$attendance = [];
while ($row = $att->fetch_array()) {
    $date = date("Y-m-d", strtotime($row['datetime_log']));
    $attendance[$row['employee_id']."_".$date]['details'] = array("eid" => $row['employee_id'], "name" => $row['ename'], "eno" => $row['work_id'], "date" => $date);
    if ($row['log_type'] == 1 || $row['log_type'] == 3) {
        if (!isset($attendance[$row['employee_id']."_".$date]['log'][$row['log_type']]))
            $attendance[$row['employee_id']."_".$date]['log'][$row['log_type']] = array('id' => $row['id'], "date" => $row['datetime_log']);
    } else {
        $attendance[$row['employee_id']."_".$date]['log'][$row['log_type']] = array('id' => $row['id'], "date" => $row['datetime_log']);
    }
}

$data = [];
foreach ($attendance as $key => $value) {
    $time_record = "";
    foreach ($attendance[$key]['log'] as $k => $v) {
        $time_record .= $lt_arr[$k] . ": " . date("h:i A", strtotime($attendance[$key]['log'][$k]['date'])) . "\n";
    }
    $data[] = array(
        'date' => $attendance[$key]['details']['date'],
        'work_id' => $attendance[$key]['details']['eno'],
        'name' => $attendance[$key]['details']['name'],
        'time_record' => $time_record
    );
}

// Create new PDF document
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);

// Column headings
$header = array('Date', 'Work Id', 'Name', 'Time Record');

// Load data
$pdf->AttendanceTable($header, $data);

// Output PDF
$pdf->Output('D', 'attendance_list.pdf');
?>
