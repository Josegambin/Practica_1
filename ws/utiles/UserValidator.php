<?php

class UserValidator
{
    private const NOMBRE_MAX    = 25;
    private const APELLIDOS_MAX = 25;
    private const TELEFONO_MAX  = 12;
    private const EMAIL_MAX     = 64;
    private const SEXO_MAX      = 1;

    /**
     * Convierte un valor de entrada en string recortado.
     * Si no es escalar (p. ej. un array de $_POST), devuelve ''.
     */
    public static function texto(mixed $valor): string
    {
        return is_scalar($valor) ? trim((string) $valor) : '';
    }

    /**
     * Devuelve null si los datos son válidos, o el primer mensaje de error.
     * Los límites coinciden con las columnas de la tabla alumno.
     */
    public static function validar(array $d): ?string
    {
        $nombre = self::texto($d['nombre'] ?? '');
        if (mb_strlen($nombre) < 1 || mb_strlen($nombre) > 25) {
            return 'El nombre debe tener entre 1 y 25 caracteres';
        }

        $apellidos = self::texto($d['apellidos'] ?? '');
        if (mb_strlen($apellidos) < 1 || mb_strlen($apellidos) > self::APELLIDOS_MAX) {
            return 'Los apellidos deben tener entre 1 y 25 caracteres';
        }

        // Opcional (la columna admite NULL). Solo dígitos y espacios, con un "+" opcional al inicio.
        $telefono = self::texto($d['telefono'] ?? '');
        if ($telefono !== '' && (mb_strlen($telefono) > self::TELEFONO_MAX
            || !preg_match('/^\+?[0-9 ]+$/', $telefono))) {
            return 'El teléfono solo puede contener números y espacios (máximo 12 caracteres, "+" opcional al inicio)';
        }

        // Opcional (la columna admite NULL).
        $email = self::texto($d['email'] ?? '');
        if ($email !== '' && (mb_strlen($email) > self::EMAIL_MAX
            || !filter_var($email, FILTER_VALIDATE_EMAIL))) {
            return 'El email no es válido';
        }

        // Opcional (la columna admite NULL). Se mantiene la longitud máxima; el valor concreto
        // (H/M, etc.) depende de tu dominio.
        $sexo = self::texto($d['sexo'] ?? '');
        if (mb_strlen($sexo) > self::SEXO_MAX) {
            return 'El sexo debe ser un único carácter';
        }

        // NOT NULL. Formato DD-MM-AAAA, entre 1900 y hoy.
        // '!' pone la hora a medianoche para que la comparación con hoy sea correcta.
        $fecha = self::texto($d['fecha_nacimiento'] ?? '');
        $f = DateTimeImmutable::createFromFormat('!d-m-Y', $fecha);
        $hoy = new DateTimeImmutable('today');
        if (
            $f === false
            || $f->format('d-m-Y') !== $fecha
            || $f > $hoy
            || $f < new DateTimeImmutable('1900-01-01')
        ) {
            return 'La fecha de nacimiento no es válida (formato DD-MM-AAAA, entre 1900 y hoy)';
        }

        return null;
    }
}
