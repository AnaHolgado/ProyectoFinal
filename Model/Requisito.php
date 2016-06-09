<?php

require_once 'ProyectoDB.php';

class Requisito {

    //Constructor  
    function __construct($codReq, $desReq, $estadoReq, $horPreReq, $horReaReq, $codPro) {
        $this->codReq = $codReq;
        $this->desReq = $desReq;
        $this->estadoReq = $estadoReq;
        $this->horPreReq = $horPreReq;
        $this->horReaReq = $horReaReq;
        $this->codPro = $codPro;
    }

    //Atributos de instancia
    private $codReq;
    private $desReq;
    private $estadoReq;
    private $horPreReq;
    private $horReaReq;
    private $codPro;

    //Métodos de instancia
    public function insert() {
        $conexion = ProyectoDB::connectDB();
        $insercion = "INSERT INTO requisito (desReq, estadoReq, horaPreReq,horaReq, codPro) VALUES (\"" . $this->desReq . "\",\"" . $this->estadoReq . "\",\"" . $this->horPreReq . "\",\"". $this->horReaReq . "\",\"" . $this->codPro . "\")";
        $conexion->exec($insercion);
    }

    public function delete() {
        $conexion = ProyectoDB::connectDB();
        $borrado = "DELETE FROM requisito WHERE codReq=\"" . $this->codReq . "\"";
        $conexion->exec($borrado);
    }

    public function update() {
        $conexion = ProyectoDB::connectDB();
        $update = "UPDATE requisito SET desReq ='$this->desReq'"
                . ", estadoReq ='$this->estadoReq', horaPreReq ='$this->horPreReq'"
                . " WHERE codReq=\"" . $this->codReq . "\"";
        $conexion->exec($update);
    }

    public static function getRequisitos() {
        $conexion = ProyectoDB::connectDB();
        $seleccion = "SELECT codReq, desReq, estadoReq, horaPreReq, horaReq, codPro FROM requisito ";
        $consulta = $conexion->query($seleccion);
        $requisitos = [];
        while ($registro = $consulta->fetchObject()) {
            $requisitos[] = new Requisito($registro->codReq, $registro->desReq, $registro->estadoReq, $registro->horaPreReq, $registro->horaReq, $registro->codPro);
        }
        return $requisitos;
    }

    public static function getRequisitosByCodPro($codPro) {
        $conexion = ProyectoDB::connectDB();
        $seleccion = "SELECT codReq, desReq, estadoReq, horaPreReq, horaReq, codPro FROM requisito WHERE codPro = \"".$codPro."\"";
        $consulta = $conexion->query($seleccion);
        $requisitos = [];
        while ($registro = $consulta->fetchObject()) {
            $requisitos[] = new Requisito($registro->codReq, $registro->desReq, $registro->estadoReq, $registro->horaPreReq, $registro->horaReq, $registro->codPro);
        }
        return $requisitos;
    }

    public static function getRequisitoById($id) {
        $conexion = ProyectoDB::connectDB();
        $seleccion = "SELECT codReq, desReq,estadoReq,horaPreReq,horaReq,codPro FROM requisito WHERE codReq=\"" . $id . "\"";
        $consulta = $conexion->query($seleccion);
        $registro = $consulta->fetchObject();
        $requisito = new Requisito($registro->codReq, $registro->desReq, $registro->estadoReq, $registro->horaPreReq, $registro->horaReq, $registro->codPro);
        return $requisito;
    }
    public static function getRequisitoByCodTar($codTar) {
        $conexion = ProyectoDB::connectDB();
        $seleccion = "SELECT codReq, desReq,estadoReq,horaPreReq,horaReq,codPro FROM requisito WHERE codReq= (SELECT codReq FROM tarea WHERE codTar = '$codTar')";
        $consulta = $conexion->query($seleccion);
        $registro = $consulta->fetchObject();
        $requisito = new Requisito($registro->codReq, $registro->desReq, $registro->estadoReq, $registro->horaPreReq, $registro->horaReq, $registro->codPro);
        return $requisito;
    }
    //UPDATE requisito SET desReq ='Nuevo Requisito', estadoReq ='EN PROCESO', horaPreReq = (SELECT SUM(horPreTar) FROM tarea WHERE codReq='60') WHERE codReq="60" 
    public function sumaHorasPrevistasTareas() {
    $conexion = ProyectoDB::connectDB();
    $update = "UPDATE requisito SET  "
                . "horaPreReq =(SELECT SUM(horPreTar) FROM tarea WHERE codReq='" . $this->codReq . "')"
                . " WHERE codReq=\"" . $this->codReq . "\"";
    $conexion->exec($update);
    
  }

  public function sumaHorasRealizadasTareas() {
    $conexion = ProyectoDB::connectDB();
    $update = "UPDATE requisito SET  "
                . "horaReq =(SELECT SUM(horReaTar) FROM tarea WHERE codReq='" . $this->codReq . "')"
                . " WHERE codReq=\"" . $this->codReq . "\"";
    $conexion->exec($update);
  }
  
  //Borrar requsitos por codPro
  public static function deleteRequisitosByCodPro($codPro) {
        $conexion = ProyectoDB::connectDB();
        $seleccion = "SELECT codReq, desReq, estadoReq, horaPreReq, horaReq, codPro FROM requisito WHERE codPro = \"".$codPro."\"";
        $consulta = $conexion->query($seleccion);
        while ($registro = $consulta->fetchObject()) {
            $requisito = new Requisito($registro->codReq, $registro->desReq, $registro->estadoReq, $registro->horaPreReq, $registro->horaReq, $registro->codPro);
            $requisito->delete();
        }
    }
    //Getter y setter de instancia
    function getCodReq() {
        return $this->codReq;
    }

    function getDesReq() {
        return $this->desReq;
    }

    function getEstadoReq() {
        return $this->estadoReq;
    }

    function getHorPreReq() {
        return $this->horPreReq;
    }

    function getHorReaReq() {
        return $this->horReaReq;
    }

    function getCodPro() {
        return $this->codPro;
    }

    function setCodReq($codReq) {
        $this->codReq = $codReq;
    }

    function setDesReq($desReq) {
        $this->desReq = $desReq;
    }

    function setEstadoReq($estadoReq) {
        $this->estadoReq = $estadoReq;
    }

    function setHorPreReq($horPreReq) {
        $this->horPreReq = $horPreReq;
    }

    function setHorReaReq($horReaReq) {
        $this->horReaReq = $horReaReq;
    }

    function setCodPro($codPro) {
        $this->codPro = $codPro;
    }


}
