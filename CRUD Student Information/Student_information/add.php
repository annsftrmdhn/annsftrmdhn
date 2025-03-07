<html>
<head>
    <title>Add Users</title>
</head>

<body>
    <a href="index.php">Go to Home</a>
    <br/><br/>

    <form action="add.php" method="post" name="form1">
        <table width="25%" border="0">
            <tr> 
                <td>NIM</td>
                <td><input type="text" name="nim" required></td>
            </tr>
            <tr> 
                <td>Student Name</td>
                <td><input type="text" name="student_name" required></td>
            </tr>
            <tr> 
                <td>Gender</td>
                <td>
                    <select name="gender" required>
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </td>
            </tr>
            <tr> 
                <td></td>
                <td><input type="submit" name="Submit" value="Add"></td>
            </tr>
        </table>
    </form>

    <?php
    if(isset($_POST['Submit'])) {
        $nim = $_POST['nim'];
        $student_name = $_POST['student_name'];
        $gender = $_POST['gender'];

        // Include database connection file
        include_once("config.php");

        // Gunakan prepared statement untuk keamanan
        $stmt = $mysqli->prepare("INSERT INTO information (nim, student_name, gender) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $nim, $student_name, $gender);

        if ($stmt->execute()) {
            echo "User added successfully. <a href='index.php'>View Users</a>";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }
    ?>
</body>
</html>
