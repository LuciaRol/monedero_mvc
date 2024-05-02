<?php

namespace Models;
use DateTime;


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

    public function obtenerSaldoTotal(){
        // meter lógica
    }

    public function registrarGasto($concepto, $importe){
        //meter lógica
    }

    public function registrarIngreso($concepto, $importe){
        //meter lógica
    }

    public function buscarConcepto(){

    }
	

}