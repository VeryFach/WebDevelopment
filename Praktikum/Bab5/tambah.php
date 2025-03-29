<?php
$file = 'catatan.txt';

$newContent = "Ini adalah teks baru yang ditambahkan.\n";

$handle = fopen($file, 'a');

if ($handle) {
    fwrite($handle, $newContent);
    fclose($handle);
    echo "Teks berhasil ditambahkan ke $file.";
} else {
    echo "Gagal membuka file $file.";
}
?>