<?php

namespace Lib;

class Pages {
    public function render(string $pageName, array $params = null): void {
        if($params !=null) {
            foreach($params as $name => $value) {
                $$name = $value;
            }
        }

        require_once 'Views/layout/header.php';
        /* si el require_once con comillas simples no funciona,
        probar las comillas dobles o probar la concatenación de la variable */
        require_once "Views/Monedero/$pageName.php"; 
        require_once 'Views/layout/footer.php';

    }
}