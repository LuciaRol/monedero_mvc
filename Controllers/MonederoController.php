<?php
namespace Controllers;

use Lib\Pages;
use Models\Monedero;
class DashboardController {
    public function mostrarDashboard():void {
        $pagina = new Pages();
        $pagina->render("mostrarMonedero");
    }
}