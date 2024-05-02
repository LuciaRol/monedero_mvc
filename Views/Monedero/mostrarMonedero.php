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

        <tr>
            <form action="<?= BASE_URL ?>controller=Monedero&action=editar" method="POST">
                <td>
                    <div class="btn">
                        <form action="<?= BASE_URL ?>controller=Monedero&action=" method="post">
                            <button name="editar" value="<?= $array['id'] ?>">Editar</button>
                        </form>
                        <form action="<?= BASE_URL ?>controller=Monedero&action=" method="POST">
                            <button name="borrar" value="<?= $array['id'] ?>">Borrar</button>
                        </form>
                    </div>
                    <button name="modificar">Modificar</button>
                </td>
            </form>
        </tr>
                
        
        <tr>
            <form action="<?= BASE_URL ?>controller=Monedero&action=" method="POST">
                <td>
                    <input type="text" name="concepto" value="">
                    <p class="error"></p>
                </td>
                <td>
                    <input type="text" name="fecha" value="">
                    <p class="error"></p>
                </td>
                <td>
                    <input type="text" name="importe" value="">
                    <p class="error"></p>
                </td>
                <td><button>Añadir registro</button></td>
            </form>
        </tr>
    </table>

    <div id="buscarConcepto">
        <p>Buscar por concepto: </p>
        <form action="<?= BASE_URL ?>controller=Monedero&action=" method="POST">
            <input type="text" name="buscar">
            <button type="submit">Buscar</button>
        </form>
    </div>
    
    <div id="">
        <div id="">
            <p>El numero total de registros es: </p>
           
            <p>El balance total es de &euro;</p>
        </div>
        <button><a href="<?= BASE_URL?>">Ver todas las anotaciones</a></button>
    </div>

</body>

</html>