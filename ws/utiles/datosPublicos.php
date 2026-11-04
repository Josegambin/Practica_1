<?php
require_once __DIR__ . '/../models/User.php';

class Utiles{

 public static function datosPublicosFilter(): ?int
    {
    $id = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT);

        if ($id === false || $id <= 0) {
            return null;
        }

        return $id;
    }

public static function datosPublicos(User $usuario): array
    {
        $datos = $usuario->toArray();
        unset($datos['id']);

        return $datos;
    }
} 

