<?php
class Mahasiswa {
    public $nim;
    public $nama;
    public $prodi;

    public function __construct($nim, $nama, $prodi) {
        $this->nim = $nim;
        $this->nama = $nama;
        $this->prodi = $prodi;
    }

    public function kuliah() {
        echo "{$this->nama} (NIM: {$this->nim}) sedang mengikuti kuliah di prodi {$this->prodi}.\n";
    }

    public function ujian() {
        echo "{$this->nama} (NIM: {$this->nim}) sedang mengikuti ujian.\n";
    }

    public function praktikum() {
        echo "{$this->nama} (NIM: {$this->nim}) sedang mengikuti praktikum.\n";
    }
}

$mhs1 = new Mahasiswa("220101", "Budi Santoso", "Teknik Informatika");

$mhs2 = new Mahasiswa("220102", "Siti Aminah", "Sistem Informasi");

$mhs1->kuliah();
$mhs1->ujian();
$mhs1->praktikum();

echo "\n";

$mhs2->kuliah();
$mhs2->ujian();
$mhs2->praktikum();
?>