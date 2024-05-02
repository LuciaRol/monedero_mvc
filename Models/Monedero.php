<?php

namespace Models;
use DateTime;


class monedero{
    private string $concepto;
    private string $fecha;
    private float $importe;


public function __construct(string $concepto, string $fecha, float $importe){
    $this->concepto = $concepto;
    $this->fecha = $fecha;
    $this->importe = $importe;
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

    public function setConcepto(string $concepto): void {
        $this->concepto = $concepto;
    }

	public function setFecha(string $fecha): void {
        $this->fecha = $fecha;
    }

	public function setImporte(float $importe): void {
        $this->importe = $importe;
    }

	

	
	

}