<?php
// Configuración de la base de datos
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'tu_password');
define('DB_NAME', 'prueba1sisedu');

// Clave de encriptación (DEBE ser segura y guardada de forma segura en producción)
define('ENCRYPTION_KEY', 'tu_clave_secreta_32bytes');

// Función para encriptar datos
function encryptData($data) {
    return openssl_encrypt($data, 'AES-256-CBC', ENCRYPTION_KEY, 0, substr(ENCRYPTION_KEY, 0, 16));
}

// Función para desencriptar datos
function decryptData($encryptedData) {
    return openssl_decrypt($encryptedData, 'AES-256-CBC', ENCRYPTION_KEY, 0, substr(ENCRYPTION_KEY, 0, 16));
}

// Conexión a la base de datos
function getDBConnection() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}
?>