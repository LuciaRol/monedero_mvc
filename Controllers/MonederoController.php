<?php
namespace Controllers;

use Lib\Pages;
use Models\Monedero;
class MonederoController {
    public function mostrarMonedero(): void {
        // Leer los datos del archivo monedero.txt
        $registros = $this->leerRegistros();

        
        // Instanciar la clase Pages para renderizar la vista
        $pagina = new Pages();
        $pagina->render("mostrarMonedero", ['registros' => $registros]);
    }
    ////////////////////////////////////////FUNCION PARA BORRAR//////////////////////
    // Función para mostrar los registros
    // public function mostrarRegistros($registros) {
    //     // Mostrar los registros en una tabla
    //     if (!empty($registros)) {
    //         echo '<table border="1">';
    //         echo '<tr><th>Concepto</th><th>Fecha</th><th>Importe (&euro;)</th></tr>';
    //         foreach ($registros as $registro) {
    //             echo '<tr>';
    //             echo '<td>' . $registro['concepto'] . '</td>';
    //             echo '<td>' . $registro['fecha'] . '</td>';
    //             echo '<td>' . $registro['importe'] . '</td>';
    //             echo '</tr>';
    //         }
    //         echo '</table>';
    //     } else {
    //         echo '<p>No hay registros.</p>';
    //     }
    // }
    ////////////////////////////////////////FUNCION PARA BORRAR//////////////////////

    public function guardarRegistro(): void {
        // Verificar si se han enviado los datos del formulario
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["concepto"], $_POST["fecha"], $_POST["importe"])) {
            // Obtener los datos del formulario
            $concepto = $_POST["concepto"];
            $fecha = $_POST["fecha"];
            $importe = $_POST["importe"];
    
            // Abrir el archivo en modo escritura (si no existe, se creará)
            $archivo = fopen("monedero.txt", "a");
    
            // Escribir los datos del formulario en el archivo
            fwrite($archivo, "$concepto,$fecha,$importe\n");
    
            // Cerrar el archivo
            fclose($archivo);
            
            // Redirigir al usuario a la página mostrarMonedero.php después de guardar el registro
            self::mostrarMonedero();
            

        } else {
            // Si no se han enviado los datos del formulario, puedes manejarlo de acuerdo a tus necesidades,
            // como mostrar un mensaje de error o redirigir al usuario a otra página.
            // Por ejemplo:
            // header("Location: formulario.php");
            // exit();
        }
    }

    public function leerRegistros(): array {
        // Leer el contenido del archivo monedero.txt si existe
        if (file_exists("monedero.txt")) {
            // Leer el contenido del archivo y dividirlo en líneas
            $lineas = file("monedero.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

            // Procesar cada línea para obtener los datos individuales
            $registros = [];
            foreach ($lineas as $linea) {
                $datos = explode(",", $linea);
                $registros[] = [
                    'concepto' => $datos[0],
                    'fecha' => $datos[1],
                    'importe' => $datos[2]
                ];
            }

            return $registros;
        } else {
            return [];
        }
    }
}