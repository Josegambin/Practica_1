<?php

class PasswordValidator
{
    private const MIN_CARACTERES = 8;
    private const MAX_BYTES = 72;

    // Validamos el password a String
    public static function validar(mixed $password): ?string
    {
        if (!is_string($password)) {
            return 'La contraseña no es válida';
        }

        if (mb_strlen($password) < self::MIN_CARACTERES) {
            return 'La contraseña debe tener al menos 8 caracteres';
        }

        //Compureba el hash del password en bytes
        if (strlen($password) > self::MAX_BYTES) {
            return 'La contraseña no puede superar 72 bytes';
        }

        if (!preg_match('/[A-Za-z]/', $password) || !preg_match('/[0-9]/', $password)) {
            return 'La contraseña debe contener al menos una letra y un número';
        }

        return null;
    }
}
