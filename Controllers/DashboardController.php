<?php
namespace Controllers;

use Lib\Pages;
use Models\Monedero;
class DashboardController {
    public function mostrarDashboard() {
        $pagina = new Pages();
        $pagina->render("dashboard");
    }
    
    public function mostrarNuevaMonedero() {
    // Ruta al archivo txt donde se almacenarán las Monederos
    $archivotxt = 'monedero.txt';
    // Si la solicitud es POST, procesar el formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Validar que los datos sean numéricos sea numérico
        if (!is_numeric($_POST['importe'])) {
            echo "Los valores introducidos no son válidos.";
            return;
        }
        
        // Crear una instancia de Monedero con los datos del formulario
        $Monedero = new Monedero(
            $_POST['concepto'] ?? '',
            $_POST['fecha'] ?? '',
            $_POST['importe'] ?? ''
        );

        // Validar la Monedero
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Crear una instancia de Monedero y procesar el formulario
            Monedero::procesarFormulario();
            $fp = fopen($archivotxt, 'a');
             // Si no se pudo abrir el archivo, muestra un mensaje de error
            if (!$fp) {
                echo "Error al abrir el archivo txt para escritura.";
            return;
            }
            // Escritura de la nueva Monedero en el archivo txt
            fputcsv($fp, $Monedero->toArray());

            // Cierra el archivo después de escribir
            fclose($fp);
        }

      
    }
 }
    public function mostrarMovimientosGuardados() {
        // Ruta al archivo CSV donde se almacenan los Monederos
        $archivoTXT  = 'monedero.txt';
    
        // Comprobar si el archivo existe
        if (!file_exists($archivoTXT )) {
            echo "No se encontró el archivo de Monederos.";
            return;
        }
    
        // Abrir el archivo en modo lectura
        $archivo = fopen($archivoTXT , 'r');
    
        // Comprobar si se pudo abrir el archivo
        if (!$archivo) {
            echo "Error al abrir el archivo de Monederos.";
            return;
        }
    
        // Mostrar una tabla HTML para los datos
        echo "<table border='1'>
                <tr>
                    <th>Concepto</th>
                    <th>Fecha</th>
                    <th>Importe</th>
                </tr>";
    
        // Leer cada línea del archivo CSV y mostrar los datos en la tabla
        while (($datos = fgetcsv($archivo)) !== false) {
            echo "<tr>";
            foreach ($datos as $dato) {
                echo "<td>" . htmlspecialchars($dato) . "</td>";
            }
            echo "</tr>";
        }
    
        echo "</table>";
    
        // Cerrar el archivo después de usarlo
        fclose($archivo);
    }

}
