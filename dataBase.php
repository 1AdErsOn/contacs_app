<?php

class Conexion{
    private $conexion;
    private $configuracion = [
        'driver' => 'mysql',
        'host' => 'localhost',
        'database' => 'contacts_app',//contacts_app
        'port' => '3306',
        'username' => 'root',
        'password' => '',
        'charset' => 'set names utf8'
    ];
    public function __construct()
    {
        
    }
    public function conectar(){
        try{ 
            $Controlador = $this->configuracion['driver'];
            $Servidor = $this->configuracion['host'];
            $Base_Datos = $this->configuracion['database'];
            $Puerto = $this->configuracion['port'];
            $Usuario = $this->configuracion['username'];
            $Clave = $this->configuracion['password'];
            $Caracteres = $this->configuracion['charset'];
            $url = "{$Controlador}:host={$Servidor}:{$Puerto};"
                ."dbname={$Base_Datos}";
            //se crea la conexion
            $this->conexion = new PDO($url,$Usuario,$Clave);
            //$conn = new PDO("mysql:host=".$dbHost.";dbname=".$dbName, $dbUsername, $dbPassword); 
            $this->conexion -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conexion -> exec($Caracteres);
            return $this->conexion;
        }catch(PDOException $e){ 
            die("Failed to connect with MySQL: " . $e->getMessage()); 
        }
    }
}
/* $host = "localhost";//127.0.0.1
$user = "root";
$password = "";
$dataBase = "contacts_app";

try {
  $conn = new PDO("mysql:host=".$host.";dbname=".$dataBase, $user, $password);
  foreach ($conn->query("SHOW DATABASES") as $row) {
    print("<pre>");
    print_r($row);
    print("</pre>");
  }
  die();
  return $conn;
}catch (PDOException $e){
  die("PDO Connection Error: ".$e->getMessage());
} */
