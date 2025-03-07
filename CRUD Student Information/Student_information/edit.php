<?php
// Sertakan file koneksi database
include_once("config.php");

// Periksa apakah formulir dikirim untuk pembaruan data mahasiswa
if (isset($_POST['update'])) {
    $old_nim = $_POST['old_nim']; // NIM sebelum diedit
    $nim = $_POST['nim']; // NIM baru yang diinputkan
    $student_name = $_POST['student_name'];
    $gender = $_POST['gender'];

    // Update data mahasiswa berdasarkan NIM lama
    $query = "UPDATE information SET nim='$nim', student_name='$student_name', gender='$gender' WHERE nim='$old_nim'";
    $result = mysqli_query($mysqli, $query);

    if ($result) {
        // Redirect ke homepage setelah update berhasil
        header("Location: index.php");
        exit();
    } else {
        echo "Gagal memperbarui data: " . mysqli_error($mysqli);
    }
}

// Ambil data mahasiswa berdasarkan NIM yang dikirim via GET
if (isset($_GET['nim'])) {
    $nim = $_GET['nim'];
    $result = mysqli_query($mysqli, "SELECT * FROM information WHERE nim='$nim'");

    if ($result && mysqli_num_rows($result) > 0) {
        $user_data = mysqli_fetch_assoc($result);
        $student_name = $user_data['student_name'];
        $gender = $user_data['gender'];
    } else {
        echo "Data mahasiswa tidak ditemukan.";
        exit();
    }
} else {
    echo "NIM tidak ditemukan.";
    exit();
}
?>

<html>
<head>    
    <title>Edit Data Mahasiswa</title>
</head>
 
<body>
    <a href="index.php">Home</a>
    <br/><br/>
    
    <form name="update_student" method="post" action="edit.php">
        <table border="0">
            <tr> 
                <td>NIM</td>
                <td><input type="text" name="nim" value="<?php echo $nim; ?>"></td>
            </tr>
            <tr> 
                <td>Nama</td>
                <td><input type="text" name="student_name" value="<?php echo $student_name; ?>"></td>
            </tr>
            <tr> 
                <td>Gender</td>
                <td>
                    <select name="gender">
                        <option value="Male" <?php if ($gender == 'Male') echo 'selected'; ?>>Male</option>
                        <option value="Female" <?php if ($gender == 'Female') echo 'selected'; ?>>Female</option>
                    </select>
                </td>
            </tr>
            <tr>
                <!-- Tambahkan input hidden untuk menyimpan NIM lama -->
                <td><input type="hidden" name="old_nim" value="<?php echo $nim; ?>"></td>
                <td><input type="submit" name="update" value="Update"></td>
            </tr>
        </table>
    </form>
</body>
</html>
