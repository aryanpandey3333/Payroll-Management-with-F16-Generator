<?php
    if ($_SERVER['REQUEST_METHOD']=='POST')
    {
        $id = $_POST['emp_id'];
        $id = intval($id);
        $pass = $_POST['emp_pass'];
        $conn = mysqli_connect("localhost", "root", "", "payroll_w_f16");
        if($conn===false)
        {
            die("ERROR: Could Not Connect To DB" . mysqli_connect_error());
        }
        $sql1= "SELECT * FROM employee WHERE emp_id = '$id' AND password = '$pass'";
        $result = mysqli_query($conn, $sql1);
        if (mysqli_num_rows($result) > 0) {
            $check = mysqli_fetch_array($result);
            echo "<table>";
                echo "<tr>";
                    echo "<th>Name</th>";
                    echo "<td>" . $check['name'] . "</td>";
                echo "</tr>";
                echo "<tr>";
                    echo "<th>EMP ID</th>";
                    echo "<td>" . $check['emp_id'] . "</td>";
                echo "</tr>";
            echo "</table>";
        } else {
            echo "<h2>No User Found</h2>";
        }
    }
?>