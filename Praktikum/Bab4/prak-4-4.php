<?php
$jurusan = [
    "Teknik Informatika",
    "Teknik Komputer",
    "Ilmu Komputer",
    "Sistem Informasi",
    "Teknologi Informasi",
    "Pendidikan Teknologi Informasi"
];

echo "Daftar Jurusan:\n";
foreach ($jurusan as $j) {
    echo "- $j\n";
}

echo "\n";

$mahasiswa = [
    "nama" => "Budi Santoso",
    "nim" => "220101010",
    "jurusan" => "Teknik Informatika",
    "angkatan" => 2022
];

echo "Data Mahasiswa:\n";
foreach ($mahasiswa as $key => $value) {
    echo ucfirst($key) . ": $value\n";
}
?>