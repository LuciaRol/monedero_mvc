<?php
namespace Controllers;

use Lib\Pages;
use Models\Monedero;
class MonederoController {
    public function mostrarMonedero(): void {
        // Leer los datos del archivo monedero.txt
        
        $registros = monedero::leerRegistros();

        
        // Instanciar la clase Pages para renderizar la vista
        $pagina = new Pages();
        $pagina->render("mostrarMonedero", ['registros' => $registros]);
    }
    public function guardarRegistro(): void {
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["concepto"], $_POST["fecha"], $_POST["importe"])) {
            // Obtener los datos del formulario
            $concepto = $_POST["concepto"];
            $fecha = $_POST["fecha"];
            $importe = $_POST["importe"];
            
            // Aquí tiene que ir toda la validación 

            // Aquí tiene que ir el saneamiento

            // Llamar a la función guardarRegistro() de Monedero para guardar el registro
            Monedero::guardarRegistro($concepto, $fecha, $importe);

            // Volvemos a redirigir al usuario
            self:: mostrarMonedero();
        }
    }
    public function borrarRegistro(): void {
        // Verificar si se ha enviado el ID del registro a borrar
    if (isset($_POST['borrar'])) {
        // Obtener el ID del registro a borrar desde el POST
        $id = $_POST['borrar'];

        // falta validar que el id obtenido es correcto y está incluido dentro del monedero.txt

        Monedero::borrarRegistro($id);
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
            $resultados = Monedero::buscarRegistros($terminoBusqueda);
    
           // Instanciar la clase Pages para renderizar la vista
            $pagina = new Pages();
            $pagina->render("mostrarMonedero", ['registros' => $resultados]);
        } 
    }

    public function contarTotalRegistros(): int {
        // Llamar a la función contarTotalRegistros() de Monedero
        return Monedero::contarTotalRegistros();
    }

    public function calcularBalanceTotal(): float {
        // Llamar a la función calcularBalanceTotal() de Monedero
        return Monedero::calcularBalanceTotal();
    }

}