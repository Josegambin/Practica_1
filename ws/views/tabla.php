<?php


require_once __DIR__ . '/../repositories/UserRepository.php';
require_once __DIR__ . '/../models/User.php';


$busqueda = trim((string) ($_GET['buscar'] ?? ''));

$repository = new UserRepository();
$usuarios = $repository->findAll();

if ($busqueda !== '') {
    $termino = mb_strtolower($busqueda);

    $usuarios = array_filter(
        $usuarios,
        function (User $usuario) use ($termino): bool {
            $texto = mb_strtolower(
                $usuario->getNombre() . ' ' . $usuario->getApellidos() . ' ' . $usuario->getEmail()
            );

            return str_contains($texto, $termino);
        }
    );
}
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

        <form method="GET" action="tabla.php">
            <label for="buscar">Buscar</label>
            <input type="text" id="buscar" name="buscar" size="40"
                   value="<?= htmlspecialchars($busqueda, ENT_QUOTES, 'UTF-8') ?>">
            <input type="submit" value="Buscar">
        </form>

        <br>

        <table border="1" cellpadding="8" cellspacing="0">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Teléfono</th>
                    <th>Email</th>
                    <th>Sexo</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($usuarios) === 0): ?>
                    <tr>
                        <td colspan="6">No hay usuarios que mostrar.</td>
                    </tr>
                <?php endif; ?>

                <?php foreach ($usuarios as $usuario): ?>
                    <tr>
                        <td><?= htmlspecialchars($usuario->getNombre(), ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($usuario->getApellidos(), ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($usuario->getTelefono(), ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($usuario->getEmail(), ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($usuario->getSexo(), ENT_QUOTES, 'UTF-8') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>

    <footer>
        <hr>
        <p><small>2026 - Jose Manuel Gambin Manresa</small></p>
    </footer>

</body>

</html>