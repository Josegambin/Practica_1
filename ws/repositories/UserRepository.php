<?php


require_once __DIR__ . '/../conexion/Conexion.php';
require_once __DIR__ . '/../models/User.php';

class UserRepository
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Conexion::getConnection();
    }

    public function findAll(): array
    {
        $stmt = $this->db->query('SELECT * FROM alumno ORDER BY id');
        $filas = $stmt->fetchAll();

        return array_map(fn(array $fila): User => $this->hydrate($fila), $filas);
    }

    public function findById(int $id): ?User
    {
        $stmt = $this->db->prepare('SELECT * FROM alumno WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $fila = $stmt->fetch();

        return $fila === false ? null : $this->hydrate($fila);
    }


    public function insert(User $usuario): int
    {
        $sql = "INSERT INTO alumno (nombre, apellidos, telefono, email, sexo, password, fecha_nacimiento)
            VALUES (:nombre, :apellidos, :telefono, :email, :sexo, :password, :fecha_nacimiento)";

        $parametros = $this->parametros($usuario) + [
            ':fecha_nacimiento' => $usuario->getfecha_nacimiento(),
        ];

        $stmt = $this->db->prepare($sql);
        $stmt->execute($parametros);

        return (int) $this->db->lastInsertId();
    }

    public function update(User $usuario): bool
    {
        $sql = 'UPDATE alumno
            SET nombre = :nombre, apellidos = :apellidos, telefono = :telefono,
                email = :email, sexo = :sexo, password = :password,
                fecha_nacimiento = :fecha_nacimiento
            WHERE id = :id';

        $parametros = $this->parametros($usuario) + [
            ':fecha_nacimiento' => $usuario->getfecha_nacimiento(),
            ':id'               => $usuario->getId(),
        ];

        $stmt = $this->db->prepare($sql);
        $stmt->execute($parametros);

        return $stmt->rowCount() > 0;
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM alumno WHERE id = :id');
        $stmt->execute([':id' => $id]);

        return $stmt->rowCount() > 0;
    }

    private function parametros(User $usuario): array
    {
        return [
            ':nombre'    => $usuario->getNombre(),
            ':apellidos' => $usuario->getApellidos(),
            ':telefono'  => $usuario->getTelefono(),
            ':email'     => $usuario->getEmail(),
            ':sexo'      => $usuario->getSexo(),
            ':password'  => $usuario->getPassword(),
            ':fecha_nacimiento' => $usuario->getfecha_nacimiento()
        ];
    }

    private function hydrate(array $fila): User
    {
        return new User(
            (int) $fila['id'],
            (string) $fila['nombre'],
            (string) $fila['apellidos'],
            (string) $fila['telefono'],
            (string) $fila['email'],
            (string) $fila['sexo'],
            (string) $fila['password'],
            (string) $fila['fecha_nacimiento']
        );
    }
}
