<?php
    define('ENCRYPT_METHOD', 'AES-256-CBC');
    define('SECRET_KEY', 'kunci-rahasia-ppdb');
    define('SECRET_IV', 'rahasia-ppdb-iv');

    function encrypt($data) {
        $key = hash('sha256', SECRET_KEY, true);
        $iv = substr(hash('sha256', SECRET_IV, true), 0, 16);

        $output = openssl_encrypt($data, ENCRYPT_METHOD, $key, 0, $iv);
        return base64_encode($output);
    }

    function decrypt($data) {
        $key = hash('sha256', SECRET_KEY, true);
        $iv = substr(hash('sha256', SECRET_IV, true), 0, 16);

        $output = openssl_decrypt(base64_decode($data), ENCRYPT_METHOD, $key, 0, $iv);
        return $output;
    }
?>