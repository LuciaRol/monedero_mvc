<?php

namespace Models;
use DateTime;
use Lib\Pages;

class monedero{
    private string $concepto;
    private string $fecha;
    private float $importe;
    private array $todosLosDatos;


public function __construct(string $concepto, string $fecha, float $importe, array $todosLosDatos){
    $this->concepto = $concepto;
    $this->fecha = $fecha;
    $this->importe = $importe;
    $this->todosLosDatos = [];
}

    public function getConcepto(): string {
        return $this->concepto;
    }

    public function getFecha(): string {
        return $this->fecha;
    }

    public function getImporte(): float {
        return $this->importe;
    }

	public function getTodosLosDatos(): array {
        return $this->todosLosDatos;
    }

	

    public function setConcepto(string $concepto): void {
        $this->concepto = $concepto;
    }

	public function setFecha(string $fecha): void {
        $this->fecha = $fecha;
    }

	public function setImporte(float $importe): void {
        $this->importe = $importe;
    }

	public function setTodosLosDatos(array $todosLosDatos): void {
        $this->todosLosDatos = $todosLosDatos;
    }

    
    public static function leerRegistros(): array {
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
    public static function guardarRegistro(string $concepto, string $fecha, float $importe): void {
        // Leer los registros actuales para obtener el último ID y calcular el siguiente ID
        $registros = self::leerRegistros();
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

        // Abrir el archivo en modo escritura (si no existe, se creará)
        $archivo = fopen("monedero.txt", "a");

        // Escribir los datos del formulario junto con el ID en el archivo
        fwrite($archivo, "$id,$concepto,$fecha,$importe\n");

        // Cerrar el archivo
        fclose($archivo);
    }

    public static function borrarRegistro(int $id): void {
        // Leer los registros actuales del archivo
        $registros = self::leerRegistros();

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

    public static function buscarRegistros(string $terminoBusqueda): array {
        // Leer los registros actuales para realizar la búsqueda
        $registros = self::leerRegistros();

        // Filtrar los registros que coincidan con el término de búsqueda en el concepto
        $resultados = [];
        foreach ($registros as $registro) {
            if (stripos($registro['concepto'], $terminoBusqueda) !== false) {
                $resultados[] = $registro;
            }
        }

        return $resultados;
    }

    public static function contarTotalRegistros(): int {
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

    public static function calcularBalanceTotal(): float {
        // Leer los registros del archivo monedero.txt
        $registros = self::leerRegistros();
        
        // Inicializar la variable para almacenar el balance total
        $balanceTotal = 0.0;

        // Sumar los importes de todos los registros
        foreach ($registros as $registro) {
            $balanceTotal += floatval($registro['importe']);
        }

        return $balanceTotal;
    }

    public static function validacion($concepto, $fecha, $importe) {
        // Inicializamos un array para almacenar mensajes de error
        $errores = [];
    
        // Comprobamos si el concepto está vacío
        if (empty($concepto)) {
            $errores['concepto'] = "No se puede dar de alta el registro: es obligatorio introducir el concepto";
        }
    
         // Comprobamos si la fecha tiene un formato válido ('d/m/aaaa')
        $fechaParts = explode('-', $fecha);
        if (count($fechaParts) !== 3 || !checkdate($fechaParts[1], $fechaParts[0], $fechaParts[2])) { //Para ordenar correctamente la fecha cambiamos el orden de fechaParts
            $errores[] = "No se puede dar de alta el registro: la fecha debe tener el formato 'd-m-aaaa'.";
        }
        // Comprobamos si el importe es un número válido
        if (!is_numeric($importe)) {
            $errores[] = "El importe debe ser un número.";
        }
    
        // Si hay errores, devolvemos un array con los mensajes de error
        if (!empty($errores)) {
            return $errores;
        }
    
        return;
    }


    public static function sanearCampos($concepto, $fecha, $importe): array {
        // Aplicar trim a todos los campos para eliminar espacios en blanco al inicio y al final
        $concepto = trim($concepto);
        $fecha = trim($fecha);
        $importe = trim($importe);
    
        // Sanear el concepto: filtrar solo letras (mayúsculas y minúsculas), números y espacios, eliminando otros caracteres
        $concepto = self::sanearString($concepto);
    
        // Sanear la fecha
        $fecha = self::sanearFecha($fecha);
    
        // Sanear el importe: eliminar todos los caracteres excepto los dígitos y el signo de puntuación para permitir números decimales
        $importe = filter_var($importe, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $importe = floatval($importe);
    
        return ['concepto' => $concepto, 'fecha' => $fecha, 'importe' => $importe];
    }
    
    // Función para sanear strings
    public static function sanearString(string $texto): string {
        // Filtrar solo letras (mayúsculas y minúsculas), números y espacios, eliminando otros caracteres
        return preg_replace('/[^A-Za-z0-9\s]+/', '', $texto);
    }

    public static function sanearFecha($fecha): ?string {
        // Intentamos convertir la fecha a un formato UNIX timestamp
        $timestamp = strtotime($fecha);
    
        // Verificamos si se pudo convertir correctamente
        if ($timestamp !== false) {
            // Creamos un objeto DateTime utilizando el timestamp
            $fecha_parseada = new DateTime();
            $fecha_parseada->setTimestamp($timestamp);
    
            // Devolvemos la fecha formateada como 'd-m-Y'
            return $fecha_parseada->format('d-m-Y');
        } else {
            // Si la conversión falla, devolvemos null
            return null;
        }
    }
}