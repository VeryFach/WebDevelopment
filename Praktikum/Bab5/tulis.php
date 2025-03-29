<?php
$content = "Ini adalah isi dari file catatan.txt";

file_put_contents("catatan.txt", $content);

echo "File catatan.txt berhasil dibuat dan ditulis.";
?>