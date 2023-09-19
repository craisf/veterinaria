<?php
require_once 'Conexion.php';

Class Mascota  extends Conexion{
  private $conexion;
  
  public function __construct(){
    $this->conexion = parent::getConexion();    
  }
  
  public function add($data = []){
    try{
      $query = $this->conexion->prepare("CALL spu_mascotas_add(?,?,?,?,?)");
      $query->execute(
        array(
                  $data['idcliente'],
                  $data['idraza'],
                  $data['nombre'],
                  $data['color'],
                  $data['genero']
                )
      );
    }catch(Exception $e){
      die($e->getMessage());
    }
  } 

  public function search($data = [])
  {
    try {
      $query = $this->conexion->prepare("CALL spu_consultar_mascotas(?)");
      $query->execute(
        array(
          $data['idmascota']
        )
      );
      return $query->fetchall(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
      die($e->getCode());
    }
  }
}