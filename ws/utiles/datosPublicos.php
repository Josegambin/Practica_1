<?php
require_once __DIR__ . '/../models/User.php';

class Utiles
{

    public static function datosPublicosFilter(): ?int
    {
        $origen ??= $_GET;
        //Si id no existe o no es un entero positivo, devolvemos null y no el error Undefined array key.
        $id = filter_var($origen['id'] ?? null, FILTER_VALIDATE_INT);

        if ($id === false || $id <= 0) {
            return null;
        }

        return $id;
    }

    public static function datosPublicos(User $usuario): array
    {
        $datos = $usuario->toArray();
        // Eliminamos el id del array de datos públicos.
        unset($datos['id']);

        return $datos;
    }
}
