<?php
    // Incluir el controlador
    use Controllers\MonederoController;

    // Crear una instancia del controlador
    $monederoController = new MonederoController();
  
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monedero</title>
</head>

<body>       
    
<table>
    <tr>
        <th class="subtitle subtitle2"><a href="index.php?action=mostrarMonedero&orden=concepto">Concepto</a></th>
        <th class="subtitle subtitle2"><a href="index.php?action=mostrarMonedero&orden=fecha">Fecha</a></th>
        <th class="subtitle subtitle2"><a href="index.php?action=mostrarMonedero&orden=importe">Importe (&euro;)</a></th>
        <th class="subtitle">Operaciones</th>
    </tr>

    <?php foreach ($registros as $registro): ?>
        <tr>
            <td><?= $registro['concepto'] ?></td>
            <td><?= $registro['fecha'] ?></td>
            <td><?= $registro['importe'] ?></td>
            <td>
                <div class="btn-container">
                    <form action="<?= BASE_URL ?>controller=Monedero&action=" method="post">
                        <button class="btn" name="editar" value="<?= $array['id'] ?>">Editar</button>
                    </form>
                    <form action="index.php?action=borrarRegistro" method="POST">
                        <button class="btn" name="borrar" value="<?= $registro['id'] ?>">Borrar</button>
                    </form>
                </div>
                
            </td>
        </tr>
    <?php endforeach; ?>

    <form action="index.php?action=guardarRegistro" method="POST">
        <td>
            <input type="text" name="concepto" placeholder="Concepto">
            <p class="error"></p>
        </td>
        <td>
            <input type="text" name="fecha" placeholder="Fecha">
            <p class="error"></p>
        </td>
        <td>
            <input type="text" name="importe" placeholder="Importe">
            <p class="error"></p>
        </td>
        <td>
            <button id="registro" class="btn" type="submit">Añadir registro</button>
        </td>
    </form>
</table>

<div id="error-messages">
    <?php if (!empty($errores)): ?>
        <ul>
            <?php foreach ($errores as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>

<div class="linea"></div>

<div id="buscarConcepto">
    <p>Buscar por concepto: </p>
    <form action="index.php?action=buscarRegistro" method="POST">
        <input class="buscar" type="text" name="buscar">
        <button class="btn" type="submit">Buscar</button>
    </form>
</div>

<div class="linea"></div>
    
<div class="anotaciones">
    <div>
        <p>El numero total de registros es: <?= $monederoController->contarTotalRegistros() ?></p>
        <p id="balance">El balance total es de <?= $monederoController->calcularBalanceTotal() ?> &euro;</p>
    </div>
    <button class="btn"><a href="index.php?action=mostrarMonedero&orden=">Ver todas las anotaciones</a></button> 
    <!-- No asignamos valor a orden para volver al original de monedero.txt -->
</div>

</body>

</html>