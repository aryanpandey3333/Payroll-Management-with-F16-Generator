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
            $emp = mysqli_fetch_array($result);
            $sql2 = mysqli_query($conn, "SELECT * FROM salary WHERE emp_id = '$id'");
            $sal = mysqli_fetch_array($sql2);
            echo "<table>";
                echo "<tr>";
                    echo "<th>Name</th>";
                    echo "<td>" . $emp['name'] . "</td>";
                echo "</tr>";
                echo "<tr>";
                    echo "<th>EMP ID</th>";
                    echo "<td>" . $emp['emp_id'] . "</td>";
                echo "</tr>";
                echo "<tr>";
                    echo "<th>Address</th>";
                    echo "<td>" . $emp['address'] . "</td>";
                echo "</tr>";
                echo "<tr>";
                    echo "<th>Contact Number</th>";
                    echo "<td>" . $emp['contact_no'] . "</td>";
                echo "</tr>";
                echo "<tr>";
                    echo "<th>Pan Number</th>";
                    echo "<td>" . $emp['pan'] . "</td>";
                echo "</tr>";
                echo "<tr>";
                    echo "<th>Income</th>";
                    echo "<td>&#8377;" . $sal['total_income'] . "</td>";
                echo "</tr>";
            echo "</table>";

            echo "
                <form id='update' action='update_investment.php' method='POST' onsubmit='submitForm(event)'>
                    <p>You can update your investment proof here:</p>
                    <label>Enter Employee ID:</label>
                    <input type='text' id='emp_id' name='emp_id' required>
                    <br>
                    <label>Investment Proof:</label>
                    <select id='cat' name='cat'>
                        <option value='80C'>80C</option>
                        <option value='80D'>80D</option>
                    </select>
                    <br>
                    <button>Update</button>
                </form>
                
                <script>
                    function submitForm(event) {
                        event.preventDefault(); // prevent the default form submission
                    
                        // get form data
                        var form = document.getElementById('update');
                        var formData = new FormData(form);
                    
                        // send form data using AJAX
                        var xhr = new XMLHttpRequest();
                        xhr.open('POST', form.action, true);
                        xhr.onload = function () {
                            if (xhr.status === 200) {
                                // handle success response
                                console.log(xhr.responseText);
                            } else {
                                // handle error response
                                console.log('Error: ' + xhr.statusText);
                            }
                        };
                        xhr.send(formData);
                    }
                </script>
        ";
            
            echo '<form action="f_16_pdf.php" method="post">
                    <label>Enter Employee ID:</label>
                    <input type="text" id="emp_id" name="emp_id" required>
                    <br>
                    <label>Enter Password:</label>
                    <input type="password" id="emp_pass" name="emp_pass" required>
                    <br>
                    <button type="submit">Generate F-16 Form</button>
                </form>';
        } else {
            echo "<h2>No User Found</h2>";
        }
        mysqli_close($conn);
    }
    
?>