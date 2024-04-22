<?php
namespace Controllers;

use Lib\Pages;
use Models\Vivienda;
class DashboardController {
    public function mostrarDashboard() {
        $pagina = new Pages();
        $pagina->render("dashboard");
    }
    
    public function mostrarNuevaVivienda() {
    // Ruta al archivo CSV donde se almacenarán las viviendas
    $archivoCSV = 'viviendas.csv';
    // Si la solicitud es POST, procesar el formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Validar que los datos sean numéricos sea numérico
        if (!is_numeric($_POST['precio'])) {
            echo "Los valores introducidos no son válidos.";
            return;
        }
       
        if (!is_numeric($_POST['tamano'])) {
            echo "Los valores introducidos no son válidos.";
            return;
        }
        
        // Crear una instancia de Vivienda con los datos del formulario
        $vivienda = new Vivienda(
            $_POST['tipo'] ?? '',
            $_POST['zona'] ?? '',
            $_POST['direccion'] ?? '',
            $_POST['dormitorios'] ?? '',
            $_POST['precio'] ?? '',
            $_POST['tamano'] ?? '',
            $_POST['extra'] ?? [],
            $_FILES['archivo']['name'] ?? '',
            $_POST['mensaje'] ?? ''
        );

        // Validar la vivienda
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Crear una instancia de Vivienda y procesar el formulario
            Vivienda::procesarFormulario();
            $fp = fopen($archivoCSV, 'a');
             // Si no se pudo abrir el archivo, muestra un mensaje de error
            if (!$fp) {
                echo "Error al abrir el archivo CSV para escritura.";
            return;
            }
            // Escritura de la nueva vivienda en el archivo CSV
            fputcsv($fp, $vivienda->toArray());

            // Cierra el archivo después de escribir
            fclose($fp);
        }

      
    }

    // Si es GET o hay errores, renderizar la página del formulario
    $pagina = new Pages();
    $pagina->render("nuevaVivienda");
    }



}
