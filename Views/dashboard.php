<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Título de tu página</title>
    <!-- Enlace al archivo de estilos externo -->
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
       <section>
        <h2>Contenido principal</h2>
        <p>Este es un espacio donde puedes empezar a agregar tu contenido principal.</p>
        
        
        <?php
        
        // Crear una instancia del controlador
        $dashboardController = new Controllers\DashboardController();

        // Llamar a la función para mostrar los Movimientos guardados
        $dashboardController->mostrarMovimientosGuardados();
        ?>
    </section>
    <footer>
        <p>Derechos de autor &copy; 2024 | Nombre de tu empresa</p>
    </footer>
</body>
</html>
