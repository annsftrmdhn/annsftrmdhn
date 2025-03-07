<?php
include_once("config.php");

$result = mysqli_query($mysqli, "SELECT * FROM information ORDER BY nim DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student List</title>
</head>

<body>
    <h2>Student Information</h2>
    <a href="add.php">Add Student</a>
    <br><br>

    <table border="1">
        <tr>
            <th>No.</th>
            <th>NIM</th>
            <th>Student Name</th>
            <th>Gender</th>
            <th>Action</th>
        </tr>
        <?php  
        $no = 1;
    while($user_data = mysqli_fetch_array($result)) {         
        echo "<tr>";
            echo "<td>" . $no . "</td>"; 
            echo "<td>" . htmlspecialchars($user_data['nim']) . "</td>";
            echo "<td>" . htmlspecialchars($user_data['student_name']) . "</td>";
            echo "<td>" . htmlspecialchars(ucfirst(strtolower($user_data['gender']))) . "</td>"; // Normalisasi gender
            echo "<td>
                    <a href='edit.php?nim=" . $user_data['nim'] . "'>Edit</a> | 
                    <a href='delete.php?nim=" . $user_data['nim'] . "' onclick=\"return confirm('Are you sure you want to delete this student?');\">Delete</a>
                  </td>";
            echo "</tr>";
            $no++; 
        }
        ?>
    </table>
</body>
</html>
