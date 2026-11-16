<?php

class UserValidator
{
    private const NOMBRE_MAX    = 25;
    private const APELLIDOS_MAX = 25;
    private const TELEFONO_MAX  = 12;
    private const EMAIL_MAX     = 64;
    private const SEXO_MAX      = 1;

    // Convierte un valor de entrada en string 
    public static function texto(mixed $valor): string
    {
        return is_scalar($valor) ? trim((string) $valor) : '';
    }

    public static function validar(array $d): ?string
    {
        $nombre = self::texto($d['nombre'] ?? '');
        if (mb_strlen($nombre) < 1 || mb_strlen($nombre) > self::NOMBRE_MAX) {
            return 'El nombre debe tener entre 1 y 25 caracteres';
        }

        $apellidos = self::texto($d['apellidos'] ?? '');
        if (mb_strlen($apellidos) < 1 || mb_strlen($apellidos) > self::APELLIDOS_MAX) {
            return 'Los apellidos deben tener entre 1 y 25 caracteres';
        }

        //admite NULL, espacios, y "+" al inicio
        $telefono = self::texto($d['telefono'] ?? '');
        if ($telefono !== '' && (mb_strlen($telefono) > self::TELEFONO_MAX
            || !preg_match('/^\+?[0-9 ]+$/', $telefono))) {
            return 'El teléfono solo puede contener números y espacios (máximo 12 caracteres, "+" opcional al inicio)';
        }

        // admite NULL
        $email = self::texto($d['email'] ?? '');
        if ($email !== '' && (mb_strlen($email) > self::EMAIL_MAX
            || !filter_var($email, FILTER_VALIDATE_EMAIL))) {
            return 'El email no es válido';
        }

        // H/M
        $sexo = self::texto($d['sexo'] ?? '');
        if (mb_strlen($sexo) > self::SEXO_MAX) {
            return 'El sexo debe ser un único carácter';
        }

        // NOT NULL. Formato DD-MM-AAAA, entre 1900 y hoy.
        $fecha = self::texto($d['fecha_nacimiento'] ?? '');
        // '!' indica media noche para calcular el dia correcto.
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
