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
    

    public function guardarRegistro(): void {
        // Verificar si se han enviado los datos del formulario
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["concepto"], $_POST["fecha"], $_POST["importe"])) {
            // Leer los registros actuales para obtener el último ID y calcular el siguiente ID
            $registros = $this->leerRegistros();
            $ultimoId = 0;

            // Calcular el último ID
            foreach ($registros as $registro) {
                $id = intval($registro['id']);
                if ($id > $ultimoId) {
                    $ultimoId = $id;
                }
            }

            // Calcular el siguiente ID
            $id = $ultimoId + 1;

    
            // Obtener los datos del formulario
            $concepto = $_POST["concepto"];
            $fecha = $_POST["fecha"];
            $importe = $_POST["importe"];
    
            // Abrir el archivo en modo escritura (si no existe, se creará)
            $archivo = fopen("monedero.txt", "a");
    
            // Escribir los datos del formulario junto con el ID en el archivo
            fwrite($archivo, "$id,$concepto,$fecha,$importe\n");
    
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
                    'id' => $datos[0],
                    'concepto' => $datos[1],
                    'fecha' => $datos[2],
                    'importe' => $datos[3]
                ];
            }

            return $registros;
        } else {
            return [];
        }
    }

    public function borrarRegistro(): void {
        // Verificar si se ha enviado el ID del registro a borrar
    if (isset($_POST['borrar'])) {
        // Obtener el ID del registro a borrar desde el POST
        $id = $_POST['borrar'];
        
        // Leer los registros actuales del archivo
        $registros = $this->leerRegistros();

        // Buscar el registro con el ID proporcionado
        $registroEncontrado = null;
        foreach ($registros as $key => $registro) {
            if ($registro['id'] == $id) {
                $registroEncontrado = $key;
                break;
            }
        }

        // Si se encuentra el registro, eliminarlo del array de registros
        if ($registroEncontrado !== null) {
            unset($registros[$registroEncontrado]);

            // Reindexar el array para evitar posibles inconsistencias de índices
            $registros = array_values($registros);

            // Escribir los registros actualizados de vuelta al archivo
            $archivo = fopen("monedero.txt", "w");
            foreach ($registros as $registro) {
                fwrite($archivo, implode(",", $registro) . "\n");
            }
            fclose($archivo);
        }
    }

    // Redirigir al usuario de vuelta a la página mostrarMonedero.php después de borrar el registro
    self::mostrarMonedero();
    }

    public function buscarRegistro(): void {
        // Verificar si se ha enviado la consulta de búsqueda
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["buscar"])) {
            // Obtener el término de búsqueda
            $terminoBusqueda = $_POST["buscar"];
    
            // Leer los registros actuales para realizar la búsqueda
            $registros = $this->leerRegistros();
    
            // Filtrar los registros que coincidan con el término de búsqueda en el concepto
            $resultados = [];
            foreach ($registros as $registro) {
                if (stripos($registro['concepto'], $terminoBusqueda) !== false) {
                    $resultados[] = $registro;
                }
            }
    
            // Instanciar la clase Pages para renderizar la vista
            $pagina = new Pages();
            $pagina->render("mostrarMonedero", ['registros' => $resultados]);
        } else {
            // Si no se ha enviado la consulta de búsqueda, puedes manejarlo de acuerdo a tus necesidades
            // Por ejemplo, puedes redirigir al usuario a otra página
            // header("Location: otra_pagina.php");
            // exit();
        }
    }

    public function contarTotalRegistros(): int {
        // Leer el contenido del archivo monedero.txt si existe
        if (file_exists("monedero.txt")) {
            // Leer el contenido del archivo y dividirlo en líneas
            $lineas = file("monedero.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    
            // Contar el número de registros (líneas)
            $totalRegistros = count($lineas);
    
            return $totalRegistros;
        } else {
            return 0;
        }
    }

    public function calcularBalanceTotal(): float {
        // Leer los registros del archivo monedero.txt
        $registros = $this->leerRegistros();
        
        // Inicializar la variable para almacenar el balance total
        $balanceTotal = 0.0;
    
        // Sumar los importes de todos los registros
        foreach ($registros as $registro) {
            $balanceTotal += floatval($registro['importe']);
        }
    
        return $balanceTotal;
    }

    public function editarRegistro(): void {
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id"], $_POST["concepto"], $_POST["fecha"], $_POST["importe"])) {
            // Obtener el ID del registro y los datos enviados desde el formulario
            $id = $_POST["id"];
            $concepto = $_POST["concepto"];
            $fecha = $_POST["fecha"];
            $importe = $_POST["importe"];
    
            // Leer los registros actuales del archivo
            $registros = $this->leerRegistros();
    
            // Buscar el registro con el ID proporcionado
            foreach ($registros as &$registro) {
                if ($registro['id'] == $id) {
                    // Actualizar los datos del registro
                    $registro['concepto'] = $concepto;
                    $registro['fecha'] = $fecha;
                    $registro['importe'] = $importe;
                    break;
                }
            }
    
            // Escribir los registros actualizados de vuelta al archivo
            $archivo = fopen("monedero.txt", "w");
            foreach ($registros as $registro) {
                fwrite($archivo, implode(",", $registro) . "\n");
            }
            fclose($archivo);
    
            // Redirigir al usuario de vuelta a la página mostrarMonedero.php después de borrar el registro
            self::mostrarMonedero();
        } else {
            // Si no se han enviado los datos del formulario, puedes manejarlo de acuerdo a tus necesidades
            // Por ejemplo, redirigir al usuario a otra página
            // header("Location: otra_pagina.php");
            // exit();
        }
    }
    
   
}