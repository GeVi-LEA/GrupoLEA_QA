<?php

class Bascula{
    
    private $folio;
    private $pesoBruto;
    private $pesoTara;
    private $unidadId;
    private $fechaEntrada;
    private $fechaSalida;
    private $base;
    private $db;

    
    public function getFolio() {
        return $this->folio;
    }

    public function getPesoTara() {
        return $this->pesoTara;
    }

    public function getUnidadId() {
        return $this->unidadId;
    }

    public function getFechaEntrada() {
        return $this->fechaEntrada;
    }

    public function getFechaSalida() {
        return $this->fechaSalida;
    }

    public function getBase() {
        return $this->base;
    }

    public function setFolio($folio): void {
        $this->folio = $folio;
    }

    public function setPesoTara($pesoTara): void {
        $this->pesoTara = $pesoTara;
    }

    public function setUnidadId($unidadId): void {
        $this->unidadId = $unidadId;
    }

    public function setFechaEntrada($fechaEntrada): void {
        $this->fechaEntrada = $fechaEntrada;
    }

    public function setFechaSalida($fechaSalida): void {
        $this->fechaSalida = $fechaSalida;
    }

    public function setBase($base): void {
        $this->base = $base;
    }
        
    public function getPesos() {
        $this->db = Database::connectBdBascula($this->getBase());
        $query = "select * from entrada where EntFol = {$this->getFolio()}";
        $smt = $this->db->query($query);
        $datos = $smt->fetch(PDO::FETCH_ASSOC);
        unset($smt);
        return $datos;
    }
}
