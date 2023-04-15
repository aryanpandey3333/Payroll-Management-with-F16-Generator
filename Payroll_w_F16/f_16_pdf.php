<?php
    require_once('TCPDF-main/tcpdf.php');

    // Connect to the database using mysqli
    $id = $_POST['emp_id'];
    $id = intval($id);
    $pass = $_POST['emp_pass'];
    $conn = mysqli_connect("localhost", "root", "", "payroll_w_f16");

    // Retrieve the F-16 form details from the database
    $sql1 = "SELECT * FROM employee e
            INNER JOIN salary s ON e.emp_id = s.emp_id
            INNER JOIN deductions d ON e.emp_id = d.emp_id
            INNER JOIN exemptions ex ON e.emp_id = ex.emp_id
            INNER JOIN tax t ON e.emp_id = t.emp_id
            INNER JOIN verification v ON e.emp_id = v.emp_id
            INNER JOIN form16_partb fb ON e.emp_id = fb.employee_id
            WHERE e.emp_id = '$id' and e.password = '$pass'";

    $result = mysqli_query($conn, $sql1);
    $row = mysqli_fetch_array($result);
    
    if (mysqli_num_rows($result) > 0) {
        // Create a new TCPDF document
        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

        // Set the document information and metadata
        $pdf->SetCreator('TCPDF');
        $pdf->SetAuthor('Your Name');
        $pdf->SetTitle('F-16 Form');
        $pdf->SetSubject('F-16 Form Details');
        $pdf->SetKeywords('F-16, Form, Details');

        // Set the font and margins
        $pdf->SetFont('times', '', 12);
        $pdf->SetMargins(20, 20, 20);

        // Add the F-16 form details to the PDF
        $pdf->AddPage();
        $pdf->Cell(0, 10, 'F-16 Form', 0, 1, 'C');
        $pdf->Ln();

        $pdf->Cell(0, 10, 'Employee Details', 'B', 1);
        $pdf->Cell(40, 10, 'Name:', 0, 0);
        $pdf->Cell(0, 10, $row['name'], 0, 1);

        $pdf->Cell(40, 10, 'Address:', 0, 0);
        $pdf->MultiCell(0, 10, $row['address'], 0, 1);

        $pdf->Cell(40, 10, 'Contact No:', 0, 0);
        $pdf->Cell(0, 10, $row['contact_no'], 0, 1);

        $pdf->Cell(40, 10, 'PAN No:', 0, 0);
        $pdf->Cell(0, 10, $row['pan'], 0, 1);

        $pdf->Ln();

        $pdf->Cell(0, 10, 'Salary Details', 'B', 1);
        $pdf->Cell(40, 10, 'Basic Salary:', 0, 0);
        $pdf->Cell(0, 10, $row['basic_salary'], 0, 1);

        $pdf->Cell(40, 10, 'Allowances:', 0, 0);
        $pdf->Cell(0, 10, $row['allowances'], 0, 1);

        $pdf->Cell(40, 10, 'Perquisites:', 0, 0);
        $pdf->Cell(0, 10, $row['perquisites'], 0, 1);

        $pdf->Cell(40, 10, 'Profit:', 0, 0);
        $pdf->Cell(0, 10, $row['profits'], 0, 1);

        $pdf->Cell(17, 10, 'Income', 0, 0);
        $pdf->Cell(40, 10, 'House Property:', 0, 0);
        $pdf->Cell(0, 10, $row['income_house_property'], 0, 1);

        $pdf->Cell(17, 10, 'Income', 0, 0);
        $pdf->Cell(40, 10, 'Capital Gains:', 0, 0);
        $pdf->Cell(0, 10, $row['income_capital_gains'], 0, 1);

        $pdf->Cell(17, 10, 'Income', 0, 0);
        $pdf->Cell(40, 10, 'Other Sources:', 0, 0);
        $pdf->Cell(0, 10, $row['income_other_sources'], 0, 1);

        $pdf->Cell(40, 10, 'Total Income:', 0, 0);
        $pdf->Cell(0, 10, $row['total_income'], 0, 1);

        $pdf->Ln();

        $pdf->Cell(0, 10, 'Deductions:', 'B', 1);
        $pdf->Cell(40, 10, 'Section:', 0, 0);
        $pdf->Cell(0, 10, $row['section'], 0, 1);

        $pdf->Cell(40, 10, 'Amount:', 0, 0);
        $pdf->Cell(0, 10, $row['amount'], 0, 1);

        $pdf->Ln();

        $pdf->Cell(0, 10, 'Exemptions', 'B', 1);
        $pdf->Cell(40, 10, 'Type:', 0, 0);
        $pdf->Cell(0, 10, $row['type'], 0, 1);

        $pdf->Cell(40, 10, 'Amount:', 0, 0);
        $pdf->Cell(0, 10, $row['amount'], 0, 1);

        $pdf->SetFont('times', 'B', 14);
        $pdf->Cell(0, 10, 'Part B - Annexure', 0, 1, 'C');
        $pdf->Cell(0, 10, 'Details of Salary Paid and any other income and tax deducted', 0, 1, 'C');

        $pdf->Ln(10);

        // create the table
        $pdf->SetFont('times', '', 12);
        $pdf->SetFont('times', '', 8);

        $pdf->Cell(20, 10, '1', 1, 0, 'C');
        $pdf->Cell(70, 10, 'Gross Salary', 1, 0, 'L');
        $pdf->Cell(70, 10, $row['gross_salary'], 1, 1, 'R');

        $pdf->Cell(20, 10, '2', 1, 0, 'C');
        $pdf->Cell(70, 10, 'Allowances to the extent exempt under section 10', 1, 0, 'L');
        $pdf->Cell(70, 10, $row['exempted_allowances'], 1, 1, 'R');

        $pdf->Cell(20, 10, '3', 1, 0, 'C');
        $pdf->Cell(70, 10, 'Value of perquisites under section 17(2)', 1, 0, 'L');
        $pdf->Cell(70, 10, $row['perquisites'], 1, 1, 'R');

        $pdf->Cell(20, 10, '4', 1, 0, 'C');
        $pdf->Cell(70, 10, 'Profits in lieu of salary under section 17(3)', 1, 0, 'L');
        $pdf->Cell(70, 10, $row['profits_in_lieu_of_salary'], 1, 1, 'R');

        $pdf->Cell(20, 10, '5', 1, 0, 'C');
        $pdf->Cell(70, 10, 'Deductions', 1, 0, 'L');
        $pdf->Cell(70, 10, $row['total_deductions'], 1, 1, 'R');

        $pdf->Cell(20, 10, '6', 1, 0, 'C');
        $pdf->Cell(70, 10, 'Income chargeable under the head Salaries (1-2-3-4-5)', 1, 0, 'L');
        $pdf->Cell(70, 10, $row['chargeable_income'], 1, 1, 'R');

        $pdf->Cell(20, 10, '7', 1, 0, 'C');
        $pdf->Cell(70, 10, 'Gross total income', 1, 0, 'L');
        $pdf->Cell(70, 10, $row['gross_total_income'], 1, 1, 'R');

        $pdf->Cell(20, 10, '8', 1, 0, 'C');
        $pdf->Cell(70, 10, 'Total taxable income', 1, 0, 'L');
        $pdf->Cell(70, 10, $row['total_taxable_income'], 1, 1, 'R');

        $pdf->Cell(20, 10, '9', 1, 0, 'C');
        $pdf->Cell(70, 10, 'Income Tax', 1, 0, 'L');
        $pdf->Cell(70, 10, $row['income_tax'], 1, 1, 'R');

        $pdf->Cell(20, 10, '10', 1, 0, 'C');
        $pdf->Cell(70, 10, 'Education cess', 1, 0, 'L');
        $pdf->Cell(70, 10, $row['education_cess'], 1, 1, 'R');

        $pdf->Cell(20, 10, '11', 1, 0, 'C');
        $pdf->Cell(70, 10, 'Total tax payable', 1, 0, 'L');
        $pdf->Cell(70, 10, $row['total_tax_payable'], 1, 1, 'R');

        $pdf->Cell(20, 10, '12', 1, 0, 'C');
        $pdf->Cell(70, 10, 'Tax payable or refundable', 1, 0, 'L');
        $pdf->Cell(70, 10, $row['tax_payable_or_refundable'], 1, 1, 'R');

        $pdf->Cell(20, 10, '', 0, 0, 'C');
        $pdf->Cell(70, 10, 'Add: Any other income reported by the employee', 0, 0, 'L');

        $pdf->Output();
    }
    else{
        echo "<script>alert('Invalid Password!');</script>";
    }
    mysqli_close($conn);
?>