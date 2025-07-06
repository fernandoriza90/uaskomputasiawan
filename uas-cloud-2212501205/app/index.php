<?php
require 'dbconn.php';

$pesan = '';

// Handle form submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nim   = trim($_POST['nim']);
    $nama  = trim($_POST['nama']);
    $email = trim($_POST['email']);

    if (!empty($nim) && !empty($nama) && !empty($email)) {
        $stmt = $conn->prepare("INSERT INTO datamahasiswa (nim, nama, email) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nim, $nama, $email);
        $stmt->execute();
        $stmt->close();

        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } else {
        $pesan = "Harap isi semua field.";
    }
}

// Ambil semua data mahasiswa
$result = $conn->query("SELECT * FROM datamahasiswa ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Form Mahasiswa</title>
</head>

<body>
    <h1>Form Input Data Mahasiswa</h1>

    <?php if ($pesan) : ?>
        <p style="color: red;"><?php echo htmlspecialchars($pesan); ?></p>
    <?php endif; ?>

    <form method="post">
        NIM: <input type="text" name="nim" required><br><br>
        Nama: <input type="text" name="nama" required><br><br>
        Email: <input type="email" name="email" required><br><br>
        <input type="submit" value="Simpan">
    </form>

    <h3>Data Mahasiswa:</h3>
    <table border="1" cellpadding="5">
        <tr>
            <th>NIM</th>
            <th>Nama</th>
            <th>Email</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) : ?>
            <tr>
                <td><?php echo htmlspecialchars($row['nim']); ?></td>
                <td><?php echo htmlspecialchars($row['nama']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>

</html>
