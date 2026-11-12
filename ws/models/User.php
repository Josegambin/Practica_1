<?php



require_once __DIR__ . '/../interfaces/IToJson.php';

class User implements IToJson
{
    private ?int $id;
    private string $nombre;
    private string $apellidos;
    private string $telefono;
    private string $email;
    private string $sexo;
    private string $password;
    private string $fecha_nacimiento;


    public function __construct(
        ?int $id,
        string $nombre,
        string $apellidos,
        string $telefono,
        string $email,
        string $sexo,
        string $password,
        string $fecha_nacimiento = ''

    ) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->telefono = $telefono;
        $this->email = $email;
        $this->sexo = $sexo;
        $this->password = $password;
        $this->fecha_nacimiento = $fecha_nacimiento;
    }

    public function getfecha_nacimiento(): string
    {
        return $this->fecha_nacimiento;
    }

    public function setfecha_nacimiento(string $fecha): self
    {
        $this->fecha_nacimiento = $fecha;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre)
    {
        $this->nombre = $nombre;
        return $this;
    }

    public function getApellidos()
    {
        return $this->apellidos;
    }

    public function setApellidos(string $apellidos)
    {
        $this->apellidos = $apellidos;
        return $this;
    }

    public function getTelefono()
    {
        return $this->telefono;
    }

    public function setTelefono(string $telefono)
    {
        $this->telefono = $telefono;
        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
        return $this;
    }

    public function getSexo()
    {
        return $this->sexo;
    }

    public function setSexo(string $sexo)
    {
        $this->sexo = $sexo;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $passwordHash): self
    {
        $this->password = $passwordHash;
        return $this;
    }

    public function toArray(): array
    {
        return [
            'id'        => $this->id,
            'nombre'    => $this->nombre,
            'apellidos' => $this->apellidos,
            'telefono'  => $this->telefono,
            'email'     => $this->email,
            'sexo'      => $this->sexo,
            'fecha_nacimiento' => $this->fecha_nacimiento
        ];
    }

    public function toJson(): string
    {
        return json_encode($this->toArray(), JSON_UNESCAPED_UNICODE);
    }
}
