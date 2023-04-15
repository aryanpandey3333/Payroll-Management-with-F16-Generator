<?php
    if ($_SERVER['REQUEST_METHOD']=='POST')
    {
        $id = $_POST['emp_id'];
        $id = intval($id);
        $conn = mysqli_connect("localhost", "root", "", "payroll_w_f16");

        if($conn===false)
        {
            die("ERROR: Could Not Connect To DB" . mysqli_connect_error());
        }
        
        $sql = "DELETE FROM salary WHERE emp_id = '$id';";
        $sql1 = "DELETE FROM deductions WHERE emp_id = '$id';";
        $sql2 = "DELETE FROM exemptions WHERE emp_id = '$id';";
        $sql3 = "DELETE FROM tax WHERE emp_id = '$id';";
        $sql4 = "DELETE FROM verification WHERE emp_id = '$id';";
        $sql5 = "DELETE FROM form16_partb WHERE employee_id = '$id';";
        $sql6 = "DELETE FROM employee WHERE emp_id = '$id';";
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
    }
    mysqli_close($conn);
?>