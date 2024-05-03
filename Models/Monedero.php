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

}