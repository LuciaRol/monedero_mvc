<?php
    // Incluir el controlador
    use Controllers\MonederoController;

    // Crear una instancia del controlador
    $monederoController = new MonederoController();

    
  
    ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

            
    
    <table>
    <tr>
    <th><a href="<?= BASE_URL ?>controller=Monedero&action=">Concepto</a></th>
    <th><a href="<?= BASE_URL ?>controller=Monedero&action=">Fecha</a></th>
    <th><a href="<?= BASE_URL ?>controller=Monedero&action=">Importe (&euro;)</a></th>
    <th>Operaciones</th>
</tr>

<?php foreach ($registros as $registro): ?>
    <tr>
        <td><?= $registro['concepto'] ?></td>
        <td><?= $registro['fecha'] ?></td>
        <td><?= $registro['importe'] ?></td>
        <td>
            <div class="btn">
                <form action="<?= BASE_URL ?>controller=Monedero&action=" method="post">
                    <button name="editar" value="<?= $array['id'] ?>">Editar</button>
                </form>
                <form action="index.php?action=borrarRegistro" method="POST">
                    <button name="borrar" value="<?= $registro['id'] ?>">Borrar</button>
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
                <button type="submit">Añadir registro</button>
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

    <div id="buscarConcepto">
        <p>Buscar por concepto: </p>
        <form action="index.php?action=buscarRegistro" method="POST">
            <input type="text" name="buscar">
            <button type="submit">Buscar</button>
        </form>
    </div>
    
    <div id="">
        <div id="">
            <p>El numero total de registros es: <?= $monederoController->contarTotalRegistros() ?></p>
        
            <p>El balance total es de &euro;<?= $monederoController->calcularBalanceTotal() ?></p>
        </div>
    <button><a href="index.php?action=mostrarMonedero">Ver todas las anotaciones</a></button>
</div>

</body>

</html>