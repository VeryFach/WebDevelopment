<?php

class ComplexEncryption {
    private $key;

    public function __construct($key) {
        $this->key = hash('sha256', $key, true);
    }

    public function encrypt($data) {
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        $encrypted = openssl_encrypt($data, 'aes-256-cbc', $this->key, OPENSSL_RAW_DATA, $iv);
        return base64_encode($iv . $encrypted);
    }

    public function decrypt($data) {
        $data = base64_decode($data);
        $iv_length = openssl_cipher_iv_length('aes-256-cbc');
        $iv = substr($data, 0, $iv_length);
        $encrypted = substr($data, $iv_length);
        return openssl_decrypt($encrypted, 'aes-256-cbc', $this->key, OPENSSL_RAW_DATA, $iv);
    }
}

class FractalGenerator {
    public function generate($depth) {
        if ($depth <= 0) return [1];
        $prev = $this->generate($depth - 1);
        return array_merge($prev, [$depth], $prev);
    }
}

class FileManipulator {
    private $filename;

    public function __construct($filename) {
        $this->filename = $filename;
    }

    public function writeData($data) {
        file_put_contents($this->filename, serialize($data));
    }

    public function readData() {
        return unserialize(file_get_contents($this->filename));
    }
}

$key = "super_secret_key";
$encryptor = new ComplexEncryption($key);
$file = new FileManipulator('data.txt');
$fractal = new FractalGenerator();

$data = $fractal->generate(5);
$encryptedData = $encryptor->encrypt(json_encode($data));
$file->writeData($encryptedData);

echo "Encrypted Data: " . $encryptedData . "\n";

delete($encryptor, $file);

function delete($encryptor, $file) {
    $decryptedData = json_decode($encryptor->decrypt($file->readData()), true);
    echo "Decrypted Data: " . implode(", ", $decryptedData) . "\n";
}
?>
