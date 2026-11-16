<?php

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../response/JsonResponse.php';
require_once __DIR__ . '/../repositories/UserRepository.php';
require_once __DIR__ . '/../utiles/UserValidator.php';
require_once __DIR__ . '/../utiles/PasswordValidator.php';
require_once __DIR__ . '/../utiles/datosPublicos.php';

header('Content-Type: application/json; charset=utf-8');

try {
    $repository = new UserRepository();

    // El id llega por GET
    $id = Utiles::datosPublicosFilter();
    if ($id === null) {
        http_response_code(400);
        echo JsonResponse::response(false, 'El id no es válido', null);
        exit;
    }

    $usuario = $repository->findById($id);
    if ($usuario === null) {
        http_response_code(404);
        echo JsonResponse::response(false, 'Usuario no encontrado', null);
        exit;
    }

    $datos = [
        'nombre'           => $usuario->getNombre(),
        'apellidos'        => $usuario->getApellidos(),
        'telefono'         => $usuario->getTelefono(),
        'email'            => $usuario->getEmail(),
        'sexo'             => $usuario->getSexo(),
        'fecha_nacimiento' => $usuario->getfecha_nacimiento(),
    ];

    // Sustituye solo los campos que llegan con valor
    foreach (array_keys($datos) as $campo) {
        $valor = UserValidator::texto($_POST[$campo] ?? '');
        if ($valor !== '') {
            $datos[$campo] = $valor;
        }
    }

    // La contraseña es opcional: si no llega, se conserva la actual
    $passwordNueva = $_POST['password'] ?? '';

    $error = UserValidator::validar($datos);
    if ($error === null && $passwordNueva !== '') {
        $error = PasswordValidator::validar($passwordNueva);
    }
    if ($error !== null) {
        http_response_code(400);
        echo JsonResponse::response(false, $error, null);
        exit;
    }

    $usuario->setNombre($datos['nombre']);
    $usuario->setApellidos($datos['apellidos']);
    $usuario->setTelefono($datos['telefono']);
    $usuario->setEmail($datos['email']);
    $usuario->setSexo($datos['sexo']);
    $usuario->setfecha_nacimiento(
        DateTimeImmutable::createFromFormat('!d-m-Y', $datos['fecha_nacimiento'])->format('Y-m-d')
    );
    if ($passwordNueva !== '') {
        $usuario->setPassword(password_hash($passwordNueva, PASSWORD_DEFAULT));
    }

    $repository->update($usuario);

    http_response_code(200);
    echo JsonResponse::response(true, 'Usuario modificado con éxito', $usuario->toArray());
} catch (Throwable $e) {
    error_log($e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Error interno del servidor']);
}
