<?php
    $name = $_POST['name'];
    $password = $_POST['password'];
    $address = $_POST['address'];
    $contact_no = $_POST['contact_no'];
    $pan = $_POST['pan'];
    $basic_salary = $_POST['basic_salary'];
    $allowances = $_POST['allowances'];
    $perquisites = $_POST['perquisites'];
    $profits = $_POST['profits'];
    $income_house_property = $_POST['income_house_property'];
    $income_capital_gains = $_POST['income_capital_gains'];
    $income_other_sources = $_POST['income_other_sources'];
    $section = $_POST['section'];
    $amount = $_POST['amount'];
    $type = $_POST['type'];
    $exemptions_amount = $_POST['exemptions_amount'];
    $tds_salary = $_POST['tds_salary'];
    $tds_other_income = $_POST['tds_other_income'];
    $advance_tax = $_POST['advance_tax'];
    $self_assessment_tax = $_POST['self_assessment_tax'];
    $declaration = $_POST['declaration'];
    $signature = $_POST['signature'];
    $date = $_POST['date'];

    $assessment_year = $_POST['assessment_year'];
    $basic_salary = $_POST['basic_salary'];//rem
    $dearness_allowance = $_POST['dearness_allowance'];
    $house_rent_allowance = $_POST['house_rent_allowance'];
    $other_allowances = $_POST['other_allowances'];
    $exempted_allowances = $_POST['exempted_allowances'];
    $gross_salary = $basic_salary + $dearness_allowance + $house_rent_allowance + $other_allowances + $exempted_allowances;
    $total_income = $gross_salary;
    $perquisites = $_POST['perquisites'];//rem
    $profits_in_lieu_of_salary = $_POST['profits_in_lieu_of_salary'];
    $deductions_upto_16 = $_POST['deductions_upto_16'];
    $deductions_upto_80c = $_POST['deductions_upto_80c'];
    $deductions_upto_80d = $_POST['deductions_upto_80d'];
    $deductions_upto_other = $_POST['deductions_upto_other'];
    $total_deductions = $deductions_upto_16 + $deductions_upto_80c + $deductions_upto_80d + $deductions_upto_other;
    $other_income = $_POST['other_income'];
    $gross_total_income = $gross_salary + $perquisites + $profits_in_lieu_of_salary + $other_income;
    $chargeable_income = $gross_total_income - $total_deductions;
    $total_taxable_income = $gross_total_income - $exempted_allowances;

    $income_tax = 0;
    if ($total_taxable_income > 1500000) {
        $income_tax += ($total_taxable_income - 1500000) * 0.3;
    }
    if ($total_taxable_income > 1250000) {
        $income_tax += ($total_taxable_income - 1250000) * 0.25;
    }
    if ($total_taxable_income > 1000000) {
        $income_tax += ($total_taxable_income - 1000000) * 0.2;
    }
    if ($total_taxable_income > 750000) {
        $income_tax += ($total_taxable_income - 750000) * 0.15;
    }
    if ($total_taxable_income > 500000) {
        $income_tax += ($total_taxable_income - 500000) * 0.1;
    }
    if ($total_taxable_income > 250000) {
        $income_tax += ($total_taxable_income - 250000) * 0.05;
    }

    $education_cess = 0.03 * $income_tax;
    $total_tax_payable = $income_tax + $education_cess;
    $tds_deducted = $_POST['tds_deducted'];
    $tax_payable_or_refundable =  $total_tax_payable - $tds_deducted;
    $investment_proof_upto_80c = $_POST['investment_proof_upto_80c'];
    $investment_proof_upto_80d = $_POST['investment_proof_upto_80d'];
    $investment_proof_others = $_POST['investment_proof_others'];

    $conn = mysqli_connect("localhost", "root", "", "payroll_w_f16");
    if(!$conn)
    {
        die("ERROR: Could Not Connect To DB" . mysqli_connect_error());
    }

    $s = "SELECT MAX(emp_id) FROM employee";
    $result = mysqli_query($conn, $s);
    $row = mysqli_fetch_array($result);
    $max_emp_id = $row[0] + 1;

    $sql = "INSERT INTO employee (emp_id, name, password, address, contact_no, pan) 
    VALUES ('$max_emp_id', '$name', '$password', '$address', '$contact_no', '$pan')";
    
    $sql1 = "INSERT INTO salary (emp_id, basic_salary, allowances, perquisites, profits, income_house_property, income_capital_gains, income_other_sources, total_income) 
    VALUES('$max_emp_id', '$basic_salary', '$allowances', '$perquisites', '$profits', '$income_house_property', '$income_capital_gains', '$income_other_sources', '$total_income')";
    
    $sql2 = "INSERT INTO deductions (emp_id, section, amount)
    VALUES ('$max_emp_id', '$section', '$amount')";

    $sql3 = "INSERT INTO exemptions (emp_id, type, amount)
    VALUES ('$max_emp_id', '$type', '$exemptions_amount')";
    
    $sql4 = "INSERT INTO tax (emp_id, tds_salary, tds_other_income, advance_tax, self_assessment_tax)
    VALUES('$max_emp_id', '$tds_salary', '$tds_other_income', '$advance_tax', '$self_assessment_tax')";
    
    $sql5 = "INSERT INTO verification (emp_id, declaration, signature, date)
    VALUES ('$max_emp_id', '$declaration', '$signature', '$date')";

    $sql6 = "INSERT INTO form16_partb (employee_id, assessment_year, gross_salary, basic_salary, dearness_allowance, house_rent_allowance, other_allowances, exempted_allowances, perquisites, profits_in_lieu_of_salary, deductions_upto_16, deductions_upto_80c, deductions_upto_80d, deductions_upto_other, total_deductions, chargeable_income, other_income, gross_total_income, total_taxable_income, income_tax, education_cess, total_tax_payable, tds_deducted, tax_payable_or_refundable, investment_proof_upto_80c, investment_proof_upto_80d, investment_proof_others)
    VALUES ('$max_emp_id', '$assessment_year', '$gross_salary', '$basic_salary', '$dearness_allowance', '$house_rent_allowance', '$other_allowances', '$exempted_allowances', '$perquisites', '$profits_in_lieu_of_salary', '$deductions_upto_16', '$deductions_upto_80c', '$deductions_upto_80d', '$deductions_upto_other', '$total_deductions', '$chargeable_income', '$other_income', '$gross_total_income', '$total_taxable_income', '$income_tax', '$education_cess', '$total_tax_payable', '$tds_deducted', '$tax_payable_or_refundable', '$investment_proof_upto_80c', '$investment_proof_upto_80d', '$investment_proof_others')";

    if (mysqli_query($conn, $sql)) {
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    if (mysqli_query($conn, $sql1)) {
    } else {
        echo "Error: " . $sql1 . "<br>" . mysqli_error($conn);
    }

    if (mysqli_query($conn, $sql2)) {
    } else {
        echo "Error: " . $sql2 . "<br>" . mysqli_error($conn);
    }

    if (mysqli_query($conn, $sql3)) {
    } else {
        echo "Error: " . $sql3 . "<br>" . mysqli_error($conn);
    }

    if (mysqli_query($conn, $sql4)) {
    } else {
        echo "Error: " . $sql4 . "<br>" . mysqli_error($conn);
    }

    if (mysqli_query($conn, $sql5)) {
    } else {
        echo "Error: " . $sql5 . "<br>" . mysqli_error($conn);
    }

    if (mysqli_query($conn, $sql6)) {
    } else {
        echo "Error: " . $sql6 . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
?>
