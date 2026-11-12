<?php

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../response/JsonResponse.php';
require_once __DIR__ . '/../repositories/UserRepository.php';
require_once __DIR__ . '../../utiles/UserValidator.php';
require_once __DIR__ . '../../utiles/PasswordValidator.php';


header('Content-Type: application/json; charset=utf-8');

try {
    $datos =  [
        'nombre' => $_POST['nombre'] ?? '',
        'apellidos' => $_POST['apellidos'] ?? '',
        'password' => $_POST['password'] ?? '',
        'email' => $_POST['email'] ?? '',
        'telefono' => $_POST['telefono'] ?? '',
        'sexo' => $_POST['sexo'] ?? '',
        'fecha_nacimiento' => $_POST['fecha_nacimiento'] ?? ''
    ];


    $error = UserValidator::validar($datos) ?? PasswordValidator::validar($datos['password']);
    if ($error !== null) {
        http_response_code(400);
        echo JsonResponse::response(false, $error, $datos);
        exit;
    }

    // La entrada llega como DD-MM-AAAA; la BD guarda AAAA-MM-DD
    $fechaBD = DateTimeImmutable::createFromFormat('!d-m-Y', $datos['fecha_nacimiento'])->format('Y-m-d');

    $repository = new UserRepository();

    $user = new User(
        null,
        $datos['nombre'],
        $datos['apellidos'],
        $datos['telefono'],
        $datos['email'],
        $datos['sexo'],
        password_hash($datos['password'], PASSWORD_DEFAULT),
        $fechaBD
    );


    $user->setId($repository->insert($user));

    http_response_code(201);
    echo JsonResponse::response(true, 'Usuario creado con éxito', $user->toArray());
} catch (Throwable $e) {
    error_log($e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Error interno del servidor']);
}
