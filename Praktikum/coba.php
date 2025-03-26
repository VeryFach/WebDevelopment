<?php
echo "Hello, World!";
echo 3 + 4;
$array = [1, 2, 3, 4, 5, 6, 7, 8, 9, 0, 3];
echo $array[0];
echo $array[3];
?>

// Menambahkan elemen ke array
$array[] = 10;
echo $array[10];

// Menghapus elemen dari array
unset($array[0]);

// Menghitung jumlah elemen dalam array
echo count($array);

// Menggunakan loop untuk menampilkan semua elemen array
foreach ($array as $value) {
    echo $value . " ";
}

// Melakukan operasi aritmatika dasar
$a = 10;
$b = 5;
echo $a + $b; // Penjumlahan
echo $a - $b; // Pengurangan
echo $a * $b; // Perkalian
echo $a / $b; // Pembagian
echo $a % $b; // Modulus

// Menggunakan while loop
$i = 0;
while ($i < count($array)) {
    echo $array[$i] . " ";
    $i++;
}

// Menggunakan do-while loop
$i = 0;
do {
    echo $array[$i] . " ";
    $i++;
} while ($i < count($array));

// Menggunakan for loop
for ($i = 0; $i < count($array); $i++) {
    echo $array[$i] . " ";
}

// Menggunakan switch case
$day = 3;
switch ($day) {
    case 1:
        echo "Monday";
        break;
    case 2:
        echo "Tuesday";
        break;
    case 3:
        echo "Wednesday";
        break;
    case 4:
        echo "Thursday";
        break;
    case 5:
        echo "Friday";
        break;
    case 6:
        echo "Saturday";
        break;
    case 7:
        echo "Sunday";
        break;
    default:
        echo "Invalid day";
}