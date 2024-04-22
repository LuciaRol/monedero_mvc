<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>    
    <main>
        <div class="title_container">
            <h2>- Formulario de registro -</h2>
            <p>Introduzca los datos de la vivienda:</p>
        </div>

        <div class="form_container">
            <form action="index.php?action=mostrarnuevavivienda" method="post" enctype="multipart/form-data">
                <div class="form_row">
                    <label for="tipo">Tipo de vivienda:</label>
                    <select id="tipo" name="tipo">
                        <option value="Piso">Piso</option>
                        <option value="Adosado">Adosado</option>
                        <option value="Chalet">Chalet</option>
                        <option value="Casa" selected>Casa</option>
                    </select>
                </div>
                
                <div class="form_row">
                    <label for="zona">Zona:</label>
                    <select id="zona" name="zona">
                        <option value="Centro" selected>Centro</option>
                        <option value="Zaidín">Zaidín</option>
                        <option value="La Chana">La Chana</option>
                        <option value="Albaicín">Albaicín</option>
                        <option value="Realejo">Realejo</option>
                        <option value="Sacromonte">Sacromonte</option>
                    </select>
                </div>

                <div class="form_row">
                    <label for="direccion">Dirección:</label>
                    <input type="text" id="direccion" name="direccion" required>
                </div>

                <div class="form_row">
                    <label for="dormitorios">Dormitorios:</label>
                    <input type="radio" id="dormitorios1" name="dormitorios"  value="1"> 1
                    <input type="radio" id="dormitorios2" name="dormitorios"  value="2"> 2
                    <input type="radio" id="dormitorios3" name="dormitorios"  value="3"> 3
                    <input type="radio" id="dormitorios4" name="dormitorios"  value="4"> 4
                    <input type="radio" id="dormitorios5" name="dormitorios"  value="5"> 5

                </div>

                <div class="form_row">
                    <label for="precio">Precio:</label>
                    <input type="number" id="precio" name="precio" placeholder="€" required>
                </div>

                <div class="form_row">
                    <label for="tamano">Tamaño:</label>
                    <input type="number" id="tamano" name="tamano" placeholder="m²" required>
                    <?php if (isset($errors['tamano'])): ?>
                        <span class="error"><?php echo $errors['tamano']; ?></span>
                    <?php endif; ?>
                </div>

                <div class="form_row">
                    <label for="archivo">Agregar foto:</label>
                    <input type="file" id="archivo" name="archivo">
                </div>
                

                <div class="form_row">
                    <label for="mensaje">Observaciones:</label>
                    <textarea id="mensaje" name="mensaje" rows="4" cols="50"></textarea>
                </div>

                <div class="insert_button">
                    <input type="submit" value="Insertar vivienda">
                </div>
            </form>
        </div>
    </main>
</body>
</html>
