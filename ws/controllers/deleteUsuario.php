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

    $repository->delete($id);

    echo JsonResponse::response(true, 'Usuario eliminado correctamente', $usuario->toArray());
} catch (Throwable $e) {
    error_log($e->getMessage());
    http_response_code(500);
    echo JsonResponse::response(false, 'Error interno del servidor', null);
}
