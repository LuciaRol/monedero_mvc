<?php

namespace Models;

class Monedero {
    public string $concepto;
    public string $fecha;
    public string $importe;
    
    public function __construct($concepto, $fecha, $importe) {
        $this->concepto = $concepto;
        $this->fecha = $fecha;
        $this->importe = $importe;
    }

    // GETTERS
    public function getconcepto() {
        return $this->concepto;
    }

    public function getfecha() {
        return $this->fecha;
    }

    public function getimporte() {
        return $this->importe;
    }

    

    // SETTERS
    public function setconcepto(string $concepto): void {
        $this->concepto = $concepto;
    }

    public function setfecha(string $fecha): void {
        $this->fecha = $fecha;
    }

    public function setimporte(string $importe): void {
        $this->importe = $importe;
    }

    
    // Método que genera un nuevo archivo php para guardar los datos introducidos
    public function generarArchivo() {
        $codigo = '<?php' . PHP_EOL;
        $codigo .= '$Monedero = new Monedero(';
        $codigo .= "'" . $this->concepto . "', ";
        $codigo .= "'" . $this->fecha . "', ";
        $codigo .= "'" . $this->importe . "', ";
        return $codigo;
    }

    // Método para procesar los datos del formulario
    public static function procesarFormulario() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $concepto = $_POST['concepto'] ?? '';
            $fecha = $_POST['fecha'] ?? '';
            $importe = $_POST['importe'] ?? '';
           
    
            
            if (!empty($concepto) && !empty($fecha) && !empty($importe)) {

                $Monedero = new Monedero($concepto, $fecha, $importe);
                if ($Monedero->esValida()) {
                } 
            }
        }
    }
    public function esValida() {
        
        if (!is_numeric($this->importe)) {
            return false;
        }
    
    
        return true;
    }

    public function toArray() {
        return [
            $this->concepto,
            $this->fecha,
            $this->importe
        ];
    }
    
}



