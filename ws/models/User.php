<?php

require_once './interfaces/IToJson.php';

class User implements IToJson
{
    public $nombre;
    public $apellidos;
    public $telefono;
    public $email;
    public $sexo;
    public $acciones;

    public function __construct($nombre, $apellidos, $telefono, $email, $sexo, $acciones)
    {
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->telefono = $telefono;
        $this->email = $email;
        $this->sexo = $sexo;
        $this->acciones = $acciones;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
        return $this;
    }

    public function getApellidos()
    {
        return $this->apellidos;
    }

    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;
        return $this;
    }

    public function getTelefono()
    {
        return $this->telefono;
    }

    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    public function getSexo()
    {
        return $this->sexo;
    }

    public function setSexo($sexo)
    {
        $this->sexo = $sexo;
        return $this;
    }

    public function getAcciones()
    {
        return $this->acciones;
    }

    public function setAcciones($acciones)
    {
        $this->acciones = $acciones;
        return $this;
    }

    public function toJson(): string
    {
        return json_encode($this) . PHP_EOL;
    }
}
