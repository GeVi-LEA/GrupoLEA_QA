<?php

class Pedimento {

    private $id;
    private $numero;
    private $referencia;
    private $tipoCambio;
    private $incrementable;
    private $otrosCargos;
    private $totalIncrementables;
    private $incrementablesPesos;
    private $valorAduana;
    private $iva;
    private $prv;
    private $ivaPrv;
    private $dta;
    private $valorComercial;
    private $totalImpuestos;
    private $fecha;
    private $documentoPedimento;
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    function getId() {
        return $this->id;
    }

    function getNumero() {
        return $this->numero;
    }

    function getReferencia() {
        return $this->referencia;
    }

    function getTipoCambio() {
        return $this->tipoCambio;
    }

    function getIncrementable() {
        return $this->incrementable;
    }

    function getOtrosCargos() {
        return $this->otrosCargos;
    }

    function getTotalIncrementables() {
        return $this->totalIncrementables;
    }

    function getIncrementablesPesos() {
        return $this->incrementablesPesos;
    }


    function getValorAduana() {
        return $this->valorAduana;
    }

    function getIva() {
        return $this->iva;
    }

    function getPrv() {
        return $this->prv;
    }

    function getIvaPrv() {
        return $this->ivaPrv;
    }

    function getDta() {
        return $this->dta;
    }

    function getValorComercial() {
        return $this->valorComercial;
    }

    function getTotalImpuestos() {
        return $this->totalImpuestos;
    }

    function getFecha() {
        return $this->fecha;
    }

    function getDocumentoPedimento() {
        return $this->documentoPedimento;
    }

    function setId($id): void {
        $this->id = $id;
    }

    function setNumero($numero): void {
        $this->numero =  strtoupper(trim($numero));
    }

    function setReferencia($referencia): void {
        $this->referencia = strtoupper(trim($referencia));
    }

    function setTipoCambio($tipoCambio): void {
        $this->tipoCambio = $tipoCambio;
    }

    function setIncrementable($incrementable): void {
        $this->incrementable = $incrementable;
    }

    function setOtrosCargos($otrosCargos): void {
        $this->otrosCargos = $otrosCargos;
    }

    function setTotalIncrementables($totalIncrementables): void {
        $this->totalIncrementables = $totalIncrementables;
    }

    function setIncrementablesPesos($incrementablesPesos): void {
        $this->incrementablesPesos = $incrementablesPesos;
    }

    function setValorAduana($valorAduana): void {
        $this->valorAduana = $valorAduana;
    }

    function setIva($iva): void {
        $this->iva = $iva;
    }

    function setPrv($prv): void {
        $this->prv = $prv;
    }

    function setIvaPrv($ivaPrv): void {
        $this->ivaPrv = $ivaPrv;
    }

    function setDta($dta): void {
        $this->dta = $dta;
    }

    function setValorComercial($valorComercial): void {
        $this->valorComercial = $valorComercial;
    }

    function setTotalImpuestos($totalImpuestos): void {
        $this->totalImpuestos = $totalImpuestos;
    }

    function setFecha($fecha): void {
        $this->fecha = $fecha;
    }

    function setDocumentoPedimento($documentoPedimento): void {
        $this->documentoPedimento = $documentoPedimento;
    }

   public function edit(){
        $sql = "update compras_pedimentos set numero='{$this->getNumero()}', referencia = '{$this->getReferencia()}', tipo_cambio = {$this->getTipoCambio()},"
        . " incrementable = {$this->getIncrementable()}, otros_cargos = {$this->getOtrosCargos()}, total_incrementables = {$this->getTotalIncrementables()},"
        . " incrementables_pesos = {$this->getIncrementablesPesos()}, valor_aduana = {$this->getValorAduana()}, iva = {$this->getIva()}, prv = {$this->getPrv()},"
        . " iva_prv = {$this->getIvaPrv()}, dta = {$this->getDta()}, valor_comercial = {$this->getValorComercial()}, total_impuestos = {$this->getTotalImpuestos()},";
        if($this->getFecha() == null){
        $sql.= "fecha_pedimento = null," ;   
        }else{
        $sql.="fecha_pedimento = '{$this->getFecha()}'";
        }
        if ($this->getDocumentoPedimento() != null) {
            $sql .= ", documento = '{$this->getDocumentoPedimento()}' ";
        }      
        $sql.="where id = {$this->getId()}";
        
        $save = $this->db->query($sql);  
        $result = false;
        if ($save) {
                $result = true;
        }else{
           $result = false;
        }
        return $result;
    }
    
    public function save(){
        $sql = "insert into compras_pedimentos values(null, '{$this->getNumero()}', '{$this->getReferencia()}', {$this->getTipoCambio()},"
        . "{$this->getIncrementable()}, {$this->getOtrosCargos()}, {$this->getTotalIncrementables()}, {$this->getIncrementablesPesos()}, {$this->getValorAduana()}, "
        . "{$this->getIva()}, {$this->getPrv()}, {$this->getIvaPrv()}, {$this->getDta()}, {$this->getValorComercial()}, {$this->getTotalImpuestos()},";
        if($this->getFecha() == null){
        $sql.= "null," ;   
        }else{
        $sql.="'{$this->getFecha()}',";
        }
        $sql.=" '{$this->getDocumentoPedimento()}');";
        $save = $this->db->query($sql);  
        $result = false;
        if ($save) {
                $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    public function getIdUltimoPedimento() {
        $sql = "SELECT MAX(id)as id FROM compras_pedimentos";
        $query = $this->db->query($sql);
        $id = $query->fetch_object()->id;
        return $id;
    }

    public function getById() {
        $sql = "select * from compras_pedimentos where id={$this->getId()}";
        $result = $this->db->query($sql);
        return $result->fetch_object();
    }
    
    public function deleteDocumentoPedimento($id) {
    $sql = "update compras_pedimentos set documento = '' where id = {$id}";
    $query = $this->db->query($sql);
    $result = false;
          if($query){
              $result = true;
          }
          return $result;
  }

}
