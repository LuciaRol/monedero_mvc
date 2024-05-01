<?php
namespace Controllers;

use Lib\Pages;
use Models\Monedero;
class MonederoController {
    public function mostrarMonedero():void {
        $pagina = new Pages();
        $pagina->render("mostrarMonedero");
    }
}