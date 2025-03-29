<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST["nama"];
    $nim = $_POST["nim"];
    $email = $_POST["email"];

    $data = "Nama: $nama | NIM: $nim | Email: $email\n";

    file_put_contents("data_mahasiswa.txt", $data, FILE_APPEND);

    echo "<h3>Data berhasil disimpan!</h3>";
    echo "<a href='form.html'>Kembali ke Form</a>";
} else {
    echo "Metode tidak diizinkan!";
}
?>