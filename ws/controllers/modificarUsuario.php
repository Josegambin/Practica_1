<?php

require_once __DIR__ . '/../repositories/UserRepository.php';
require_once __DIR__ . '/../response/JsonResponse.php';
require_once __DIR__ . '/../utiles/datosPublicos.php';

header('Content-Type: application/json; charset=utf-8');

try {
    $id = Utiles::datosPublicosFilter();

    if ($id === null) {
        http_response_code(400);
        echo JsonResponse::response(false, 'El id no es válido', null);
        exit;
    }

    $repository = new UserRepository();
    $usuario = $repository->findById($id);

    if ($usuario === null) {
        http_response_code(404);
        echo JsonResponse::response(false, "Usuario con id $id no encontrado", null);
        exit;
    }

    $datos = [
        'nombre'    => $_REQUEST['nombre'] ?? '',
        'apellidos' => $_REQUEST['apellidos'] ?? '',
        'password'  => $_REQUEST['password'] ?? '',
        'email'     => $_REQUEST['email'] ?? '',
        'telefono'  => $_REQUEST['telefono'] ?? '',
        'sexo'      => $_REQUEST['sexo'] ?? '',
    ];

    // $error = UserValidator::validar($datos);

    // if ($error !== null) {
    //     http_response_code(400);
    //     echo JsonResponse::response(false, $error, null);
    //     exit;
    // }

    // Solo se cambian los campos que que tienen valor.
    foreach ($datos as $campo => $valor) {
        if ($valor === '') {
            continue;
        }

        if ($campo === 'password') {
            $valor = password_hash($valor, PASSWORD_DEFAULT);
        }

        $metodo = 'set' . ucfirst($campo);
        $usuario->$metodo($valor);
    }

    $repository->update($usuario);

    echo JsonResponse::response(true, 'Usuario modificado correctamente', Utiles::datosPublicos($usuario));
} catch (Throwable $e) {
    error_log($e->getMessage());
    http_response_code(500);
    echo JsonResponse::response(false, 'Error interno del servidor', null);
}
