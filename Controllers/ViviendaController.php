<?php

namespace Controllers;

use Models\Vivienda;
use Lib\Pages;

class ViviendaController {
    public function mostrarDatos() {
        $tipo = $_POST['tipo'] ?? 'No especificado';
        $zona = $_POST['zona'] ?? 'No especificado';
        $direccion = $_POST['direccion'] ?? 'No especificado';
        $dormitorios = $_POST['dormitorios'] ?? 'No especificado';
        $precio = $_POST['precio'] ?? 'No especificado';
        $tamano = $_POST['tamano'] ?? 'No especificado';
        $observaciones = $_POST['mensaje'] ?? 'No especificado';
        $archivo = $_FILES['archivo'] ?? null;

        $data = [
            'tipo' => $tipo,
            'zona' => $zona,
            'direccion' => $direccion,
            'dormitorios' => $dormitorios,
            'precio' => $precio,
            'tamano' => $tamano,
            'observaciones' => $observaciones,
            'imagePath' => null,
            'beneficio' => null
        ];
        
        // Define los porcentajes de beneficio por zona y tamaño
        $porcentajesBeneficio = [
            'Centro' => ['Menos de 100 m2' => 0.30, 'Más de 100 m2' => 0.35],
            'Zaidín' => ['Menos de 100 m2' => 0.25, 'Más de 100 m2' => 0.28],
            'Chana' => ['Menos de 100 m2' => 0.22, 'Más de 100 m2' => 0.25],
            'Albaicín' => ['Menos de 100 m2' => 0.20, 'Más de 100 m2' => 0.35],
            'Sacromonte' => ['Menos de 100 m2' => 0.22, 'Más de 100 m2' => 0.25],
            'Realejo' => ['Menos de 100 m2' => 0.25, 'Más de 100 m2' => 0.28]
        ];

        // Calcula el beneficio en base a la zona y el tamaño
        if (isset($porcentajesBeneficio[$zona])) {
            if ($tamano <= 100) {
                $data['beneficio'] = $porcentajesBeneficio[$zona]['Menos de 100 m2'];
            } else {
                $data['beneficio'] = $porcentajesBeneficio[$zona]['Más de 100 m2'];
            }
        }

        if ($archivo && $archivo['error'] == UPLOAD_ERR_OK) {
            // Comprueba el tamaño de la foto
            if ($archivo['size'] > 100 * 1024) { 
                $data['error'] = "El tamaño de la foto no debe exceder los 100KB.";
            } else {
                $uploadDir = __DIR__ . '/../Views/fotos/';
                $uploadFile = $uploadDir . basename($archivo['name']);
                
                // Comprueba si existe la carpeta donde se guardan las fotos.
                // Si no existe, se crea el directorio.
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                
                if (move_uploaded_file($archivo['tmp_name'], $uploadFile)) {
                    $imagePath = 'Views/fotos/' . htmlspecialchars(basename($archivo['name']));
                    $data['imagePath'] = $imagePath;
                }
            }
        } else {
            $data['error'] = "No se subió ninguna foto o el tamaño de la misma excedió los 100 kb.";
        }

        return $data;
    }

}