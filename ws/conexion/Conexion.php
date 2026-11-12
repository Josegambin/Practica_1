<?php

require_once __DIR__ . '/../config/config.php';

class Conexion
{
    private static ?PDO $connection = null;

    public static function getConnection(): PDO
    {
        if (self::$connection === null) {
            $dsn = sprintf(
                'mysql:host=%s;dbname=%s;charset=%s',
                HOST,
                NAME,
                CHARSET
            );

            $options = [
                // Lanza una excepción (PDOException) si una consulta falla.
                // Sin esto, los errores pasarían en silencio.
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                // Por defecto, fetch() devuelve arrays con nombres de columna (no con índices numéricos).
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                // Usa sentencias preparadas reales de MySQL, no emuladas en PHP.
                // Es más seguro frente a inyección SQL.
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            self::$connection = new PDO($dsn, USER, PASS, $options);
        }

        return self::$connection;
    }
}
