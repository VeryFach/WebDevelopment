<?php
// Menerima dua inputan dan menjumlahkan
function jumlah ($a, $b) {
    return $a + $b;
}

echo "Hasil dari penjumlahan 50 + 48 = " . jumlah(50,48) . "\n";
echo "Hasil dari penjumlahan 60 + 78 = " . jumlah(60,78) . "\n";

echo "Masukan bilangan pertama: ";
$a = trim(fgets(STDIN));
echo "Masukan bilangan kedua: ";
$b = trim(fgets(STDIN));
echo "Hasil Penjumlahan $a + $b =" . jumlah($a, $b) . "\n";

// Menghitung pajang string
function panjangString ($str) {
    return strlen($str);
}

echo "Masukan kata pertama: ";
$str1 = trim(fgets(STDIN));
echo "Panjang string '$str1' =   " . panjangString($str1) . "\n";

echo "Masukan bilangan kedua: ";
$str2 = trim(fgets(STDIN));
echo "Panjang String '$str2' = " .panjangString($str2) . "\n";

?>