<?php

require_once __DIR__ . '/../repositories/UserRepository.php';
require_once __DIR__ . '/../response/JsonResponse.php';
require_once __DIR__ . '/../utiles/datosPublicos.php';

header('Content-Type: application/json; charset=utf-8');

try {
    $repository = new UserRepository();

    if (!isset($_GET['id'])) {
        $usuarios = array_map(
        fn (User $usuario): array => Utiles::datosPublicos($usuario),
        $repository->findAll()
        );

        echo JsonResponse::response(true, 'Usuarios obtenidos correctamente', $usuarios);
        exit;
    }

        $id = Utiles::datosPublicosFilter();

    if ($id === null) {
        http_response_code(400);
        echo JsonResponse::response(false, 'El id no es válido', null);
        exit;
    }

    $usuario = $repository->findById($id);

    if ($usuario === null) {
        http_response_code(404);
        echo JsonResponse::response(false, "Usuario con id $id no encontrado", null);
        exit;
    }

    echo JsonResponse::response(true, 'Usuario obtenido correctamente', Utiles::datosPublicos($usuario));
} catch (Throwable $e) {
    error_log($e->getMessage());
    http_response_code(500);
    echo JsonResponse::response(false, 'Error interno del servidor', null);
}
