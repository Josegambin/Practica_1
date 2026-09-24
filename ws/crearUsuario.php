<?php

require_once __DIR__ . '/models/User.php';

header('Content-Type: application/json; charset=utf-8');

$nombre  = $_POST['nombre']  ?? '';
$apellidos  = $_POST['apellidos']  ?? '';
$password  = $_POST['password']  ?? '';
$email  = $_POST['email']  ?? '';
$telefono  = $_POST['telefono']  ?? '';
$sexo = $_POST['sexo'] ?? '';
$acciones = $_POST['acciones']  ?? '';

$user = new User($nombre, $apellidos, $telefono, $email, $sexo, $acciones);

$rutaFichero = __DIR__ . '/usuarios.txt';
$linea = $user->toJson();

if (file_put_contents($rutaFichero, $linea, FILE_APPEND | LOCK_EX) === false) {
    http_response_code(500);
    echo json_encode(['error' => 'No se pudo guardar en el fichero']);
    exit;
}

echo $user->toJson();
