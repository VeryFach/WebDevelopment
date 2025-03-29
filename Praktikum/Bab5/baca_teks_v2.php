<?php
$file = fopen("data.txt", "r");

echo "<h3>Isi dari data.txt:</h3><pre>";

while (!feof($file)) {
    $baris = fgets($file);
    echo $baris;
}

echo "</pre>";
fclose($file);
?>