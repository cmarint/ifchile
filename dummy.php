<?php
//include('Crypt/AES.php');
//include('Crypt/Random.php');

$cipher = new Crypt_AES(); // could use CRYPT_AES_MODE_CBC
// keys are null-padded to the closest valid size
// longer than the longest key and it's truncated
//$cipher->setKeyLength(256);

$plaintext = "4998471019927210";
$clave = hash('sha256', $plaintext, true);

$cipher->setKey($clave);
// the IV defaults to all-NULLs if not explicitly defined
$cipher->setIV(crypt_random_string($cipher->getBlockLength() >> 3));

//$size = 10 * 1024;
//$plaintext = str_repeat('a', $size);

echo $cipher->decrypt($cipher->encrypt($plaintext));






?>
