<?php
use Controllers\ViviendaController;

$controller = new ViviendaController();
$data = $controller->mostrarDatos();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Información de la Nueva Vivienda</title>
</head>
<body>
    <h1>Información de la nueva vivienda</h1>

    <p><strong>Tipo de vivienda:</strong> <?= $data['tipo']; ?></p>
    <p><strong>Zona:</strong> <?= $data['zona']; ?></p>
    <p><strong>Dirección:</strong> <?= $data['direccion']; ?></p>
    <p><strong>Dormitorios:</strong> <?= $data['dormitorios']; ?></p>
    <p><strong>Precio:</strong> <?= $data['precio']; ?> €</p>
    <p><strong>Tamaño:</strong> <?= $data['tamano']; ?> m<sup>2</sup></p>

    <?php if (isset($data['imagePath'])): ?>
        <p> <img src="<?= $data['imagePath']; ?>" alt="Imagen de la vivienda" style="width: 300px;"></p>
    <?php else: ?>
        <p>No se subió ninguna foto o su tamaño excede los 100kb.</p>
    <?php endif; ?>

    <p><strong>Observaciones:</strong> <?= $data['observaciones']; ?></p>
    <p><strong>Beneficio:</strong> <?= $data['beneficio'] * $data['precio']; ?>€</p>
</body>
</html>
