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
        $sec = $_POST['cat'];
        $sql = "UPDATE DEDUCTIONS SET section='$sec' where emp_id='$id'";
        mysqli_query($conn, $sql);
    }

?>