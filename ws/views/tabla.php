<?php

require_once __DIR__ . '/../repositories/UserRepository.php';
require_once __DIR__ . '/../models/User.php';

$busqueda = trim((string) ($_GET['buscar'] ?? ''));

$repository = new UserRepository();
$usuarios = $repository->findAll();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Tabla de datos</title>
    <link rel="stylesheet" href="../../public/css/estilos.css">

</head>

<body>

    <header>
        <h1>Tabla de datos registrados</h1>
        <hr>
        <nav>
            <ul>
                <li><a href="../index.html">Inicio</a></li>
                <li><a href="../../public/html/formulario.html">Formulario</a></li>
                <li><a href="../../ws/views/tabla.php">Tabla de datos</a></li>
                <li><a href="../../public/html/galeria.html">Galería</a></li>
                <li><a href="../../public/html/contacto.html">Contacto</a></li>
            </ul>
        </nav>
        <hr>
    </header>

    <main>
        <h2>Alumnos registrados</h2>

        <label for="buscar">Buscar</label>
        <input type="text" id="buscar" size="40" placeholder="Nombre, apellidos o email">

        <br><br>

        <table border="1" cellpadding="8" cellspacing="0" id="tabla-usuarios">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Teléfono</th>
                    <th>Email</th>
                    <th>Sexo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usuario): ?>
                    <?php $sexos = ['H' => 'Hombre', 'M' => 'Mujer', 'O' => 'Otro']; ?>
                    <tr data-id="<?= $usuario->getId() ?>">
                        <td><?= htmlspecialchars($usuario->getNombre(), ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($usuario->getApellidos(), ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($usuario->getTelefono() ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($usuario->getEmail() ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($sexos[$usuario->getSexo()] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                        <td>
                            <a href="../controllers/editUsuario.php?id=<?= $usuario->getId() ?>" title="Modificar">✏️</a>
                            <button type="button" class="btn-eliminar" data-id="<?= $usuario->getId() ?>" title="Eliminar">❌</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr id="sin-resultados" style="display:none;">
                    <td colspan="6">No hay usuarios que mostrar.</td>
                </tr>
            </tbody>
        </table>

    </main>

    <footer>
        <hr>
        <p><small>2026 - Jose Manuel Gambin Manresa</small></p>
    </footer>
    <script src="../../js/acciones.js"></script>
</body>

</html>