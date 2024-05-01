<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    $id = 0;
    // Compruebo que la variable $erroresEdit esté vacía y en caso contrario los muestra
    if (!empty($erroresEdit)) : ?>
        <div class="editErr">
            <p>¡Errores en el campo editar!</p>
            <ul>
                <?php
                // Recorro el array y muestro su valor.
                foreach ($erroresEdit as $key => $error) {
                    echo "<li>" . $error . "</li>";
                }
                ?>
            </ul>
        </div>
    <?php
    endif;
    ?>
    <table>
        <tr>
            <th><a href="<?= BASE_URL ?>controller=Monedero&action=">Concepto</a></th>
            <th><a href="<?= BASE_URL ?>controller=Monedero&action=">Fecha</a></th>
            <th><a href="<?= BASE_URL ?>controller=Monedero&action=">Importe (&euro;)</a></th>
            <th>Operaciones</th>
        </tr>
        <?php if (isset($conceptos) && !empty($conceptos)) : ?>
            <?php foreach ($conceptos as $key => $array) : ?>
                <?php if ($key > 0) : ?>
                    <tr>
                        <?php if (str_contains($array["concepto"], "input")) { ?>
                            <form action="<?= BASE_URL ?>controller=Monedero&action=editar" method="POST">
                            <?php } ?>
                            <?php foreach ($array as $clave => $value) : ?>
                                <?php if ($clave != "id") { ?>
                                    <td>
                                        <?= $value ?>
                                    </td>
                                <?php } ?>
                            <?php endforeach; ?>
                            <td>
                                <?php
                                if (!str_contains($array["concepto"], "input")) { ?>
                                    <div class="buttons">
                                        <form action="<?= BASE_URL ?>controller=Monedero&action=cargaEditar" method="post">
                                            <button name="edit" value="<?= $array['id'] ?>">EDITAR</button>
                                        </form>
                                        <form action="<?= BASE_URL ?>controller=Monedero&action=borrar" method="POST">
                                            <button name="delete" value="<?= $array['id'] ?>">BORRAR</button>
                                        </form>
                                    </div>
                                <?php } else { ?>
                                    <button name="edit" value="<?= $key ?>">EDITAR</button>
                            </form>
                        <?php } ?>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
        <tr>
            <form action="<?= BASE_URL ?>controller=Monedero&action=valida" method="POST">
                <td>
                    <input type="text" name="concept" value="<?= (!empty($errores)) ? $_POST['concept'] : "" ?>">
                    <p class="err"><?= isset($errores["concept"]) ? $errores["concept"] : "" ?></p>
                </td>
                <td>
                    <input type="text" name="date" value="<?= (!empty($errores)) ? $_POST['date'] : "" ?>">
                    <p class="err"><?= isset($errores["date"]) ? $errores["date"] : "" ?></p>
                </td>
                <td>
                    <input type="text" name="import" value="<?= (!empty($errores)) ? $_POST['import'] : "" ?>">
                    <p class="err"><?= isset($errores["import"]) ? $errores["import"] : "" ?></p>
                </td>
                <td><button>AÑADIR</button></td>
            </form>
        </tr>
    </table>
    <div id="search">
        <p>Buscar por concepto: </p>
        <form action="<?= BASE_URL ?>controller=Monedero&action=search" method="POST">
            <input type="text" name="search">
            <button type="submit">BUSCAR</button>
        </form>
    </div>
    <div id="noTable">
        <div id="resumen">
            <p>El numero total de registros es: <?php
                                                if (isset($_GET['action']) && $_GET['action'] == "search") {
                                                    echo count($conceptos);
                                                } else {
                                                    echo count($conceptos) - 1;
                                                }
                                                ?></p>
            <?php
            // Recorro los conceptos y cogiendo el importe solamente lo sumo y lo muestro como suma total.
            $suma = 0;
            foreach ($conceptos as $key => $array) {
                foreach ($array as $key => $value) {
                    if ($key == "importe") {
                        $suma += floatval($value);
                    }
                }
            }
            ?>
            <p>El balance total es de <?= $suma ?>&euro;</p>
        </div>
        <button><a href="<?= BASE_URL ?>">Ver todas las anotaciones</a></button>
    </div>

</body>

</html>