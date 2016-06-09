<?php

require_once 'ProyectoDB.php';

class Usuario {

    //Atributos de clase
    private static $numUsuTotales = 0;

    //Métodos de clase
    /*
      static function getNumUsuTotales() {
      return self::$numUsuTotales;
      }

      static function setNumUsuTotales($numUsuTotales) {
      self::$numUsuTotales = $numUsuTotales;
      } */
    //Constructor  
    function __construct($codUsu, $nomUsu, $emailUsu, $catUsu, $loginUsu, $passUsu, $permisoUsu) {
        $this->codUsu = $codUsu;
        $this->nomUsu = $nomUsu;
        $this->emailUsu = $emailUsu;
        $this->catUsu = $catUsu;
        $this->permisoUsu = $permisoUsu;
        $this->loginUsu = $loginUsu;
        $this->passUsu = $passUsu;
    }

    //Atributos de instancia
    private $codUsu;
    private $nomUsu;
    private $emailUsu;
    private $catUsu;
    private $permisoUsu;
    private $loginUsu;
    private $passUsu;

    //Métodos de instancia
    public function insert() {
        $conexion = ProyectoDB::connectDB();
        $insercion = "INSERT INTO usuario VALUES (\"\",\"" . $this->nomUsu . "\",\"" . $this->emailUsu . "\", \"" . $this->catUsu . "\",\"" . $this->loginUsu . "\", \"" . $this->passUsu . "\",\"" . $this->permisoUsu . "\")";
        $conexion->exec($insercion);

        $seleccion = " SELECT codUsu FROM usuario WHERE codUsu = (SELECT MAX(codUsu) AS idUsuario FROM usuario )";
        $consulta = $conexion->query($seleccion);
        $registro = $consulta->fetchObject();        
    }

    public function delete() {
        $conexion = ProyectoDB::connectDB();
        $borrado = "DELETE FROM usuario WHERE codUsu=\"" . $this->codUsu . "\"";
        $conexion->exec($borrado);
    }

    public function update() {
        $conexion = ProyectoDB::connectDB();
        $update = "UPDATE usuario SET nomUsu ='$this->nomUsu'"
                . ", emailUsu ='$this->emailUsu', catUsu ='$this->catUsu', loginUsu ='$this->loginUsu'"
                . ", permisoUsu ='$this->permisoUsu'"
                . ", passUsu ='$this->passUsu'"
                . " WHERE codUsu=\"" . $this->codUsu . "\"";
        $conexion->exec($update);
    }

    public static function getUsuarios() {
        $conexion = ProyectoDB::connectDB();
        $seleccion = "SELECT codUsu, nomUsu, emailUsu, catUsu, loginUsu, passUsu, permisoUsu FROM usuario";
        $consulta = $conexion->query($seleccion);
        $usuarios = [];
        while ($registro = $consulta->fetchObject()) {
            $usuarios[] = new Usuario($registro->codUsu, $registro->nomUsu, $registro->emailUsu, $registro->catUsu, $registro->loginUsu, $registro->passUsu, $registro->permisoUsu);
        }
        return $usuarios;
    }

    public static function getUsuarioById($id) {
        $conexion = ProyectoDB::connectDB();
        $seleccion = "SELECT codUsu,nomUsu,catUsu,emailUsu,loginUsu,passUsu,permisoUsu FROM usuario WHERE codUsu=\"" . $id . "\"";
        $consulta = $conexion->query($seleccion);
        $registro = $consulta->fetchObject();
        $usuario = new Usuario($registro->codUsu, $registro->nomUsu, $registro->emailUsu, $registro->catUsu, $registro->loginUsu, $registro->passUsu, $registro->permisoUsu);
        return $usuario;
    }
    public static function getUsuarioByLogin($login) {
        $conexion = ProyectoDB::connectDB();
        $seleccion = "SELECT codUsu,nomUsu,catUsu,emailUsu,loginUsu,passUsu,permisoUsu FROM usuario WHERE loginUsu=\"" . $login . "\"";
        $consulta = $conexion->query($seleccion);
        $registro = $consulta->fetchObject();
        $usuario = new Usuario($registro->codUsu, $registro->nomUsu, $registro->emailUsu, $registro->catUsu, $registro->loginUsu, $registro->passUsu, $registro->permisoUsu);
        
        return $usuario;
    }

    //Getter y setter de instancia
    function getCodUsu() {
        return $this->codUsu;
    }

    function getNomUsu() {
        return $this->nomUsu;
    }

    function getEmailUsu() {
        return $this->emailUsu;
    }

    function getCatUsu() {
        return $this->catUsu;
    }

    function getPermisoUsu() {
        return $this->permisoUsu;
    }

    function getLoginUsu() {
        return $this->loginUsu;
    }

    function getPassUsu() {
        return $this->passUsu;
    }

    function setCodUsu($codUsu) {
        $this->codUsu = $codUsu;
    }

    function setNomUsu($nomUsu) {
        $this->nomUsu = $nomUsu;
    }

    function setEmailUsu($emailUsu) {
        $this->emailUsu = $emailUsu;
    }

    function setCatUsu($catUsu) {
        $this->catUsu = $catUsu;
    }

    function setPermisoUsu($permisoUsu) {
        $this->permisoUsu = $permisoUsu;
    }

    function setLoginUsu($loginUsu) {
        $this->loginUsu = $loginUsu;
    }

    function setPassUsu($passUsu) {
        $this->passUsu = $passUsu;
    }

}
