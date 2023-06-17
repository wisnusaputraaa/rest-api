<?php
// Inisialisasi koneksi ke database

$conn = mysqli_connect("localhost", "root", "", "database");

// Periksa koneksi
if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>
<?php
// ...


// Endpoint API untuk menyimpan data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['endpoint']) && $_POST['endpoint'] === 'data') {
    // Periksa apakah semua data yang dibutuhkan telah diterima
    if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password'])) {
        // Ambil data yang diterima
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Query untuk menyimpan data ke database
        $query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
        $result = mysqli_query($conn, $query);

        // Periksa apakah query berhasil dieksekusi
        if ($result) {
            echo "Data berhasil disimpan";
        } else {
            // Jika query gagal
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Data yang diperlukan tidak lengkap";
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['endpoint']) && $_GET['endpoint'] === 'data') {
    // Query untuk mendapatkan data dari database
    $query = "SELECT * FROM users";
    $result = mysqli_query($conn, $query);

    // Periksa apakah query berhasil dieksekusi
    if ($result) {
        // Inisialisasi array kosong untuk menyimpan data
        $data = [];

        // Ambil hasil query satu per satu dan tambahkan ke array data
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }

        // Set header konten sebagai JSON
        header('Content-Type: application/json');

        // Cetak data dalam format JSON
        echo json_encode($data);
    } else {
        // Jika query gagal
        echo "Error: " . mysqli_error($conn);
    }
}

// Tutup koneksi ke database
mysqli_close($conn);
?>
