<?php
session_start();
$rol = isset($_SESSION['rol']) ? $_SESSION['rol'] : null;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Mis Permisos</title>
</head>
<body>
    <?php include __DIR__ . '/views/partials/menu.php'; ?>
    <h1>Mis Permisos</h1>
    <?php if ($rol === 'admin'): ?>
        <ul>
            <li>Gestionar usuarios</li>
            <li>Ver y generar reportes</li>
            <li>Acceso total al sistema</li>
        </ul>
    <?php elseif ($rol === 'conductor'): ?>
        <ul>
            <li>Ver y gestionar mis viajes</li>
            <li>Editar mi perfil</li>
        </ul>
    <?php elseif ($rol === 'cliente'): ?>
        <ul>
            <li>Reservar viajes</li>
            <li>Ver mis reservas</li>
        </ul>
    <?php else: ?>
        <p>No tienes permisos asignados.</p>
    <?php endif; ?>
</body>
</html>
