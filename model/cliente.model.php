<?php
require_once 'Conexion.php';

class Cliente   extends Conexion
{
  private $conexion;

  public function __CONSTRUCT()
  {
    $this->conexion = parent::getConexion();
  }

  public function add($data = [])
  {
    try {
      $query = $this->conexion->prepare("CALL spu_clientes_add(?,?,?,?)");
      $query->execute(
        array(
          $data['apellidos'],
          $data['nombres'],
          $data['dni'],
          $data['claveacceso']
        )
      );
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  public function login($username)
  {
    try {
      $query = $this->conexion->prepare("CALL spu_login(?)");
      $query->execute(
        array($username)
      );
      return $query->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }


  public function searchDNI($data = [])
  {
    try {
      $query = $this->conexion->prepare("CALL spu_consultar_cliente(?)");
      $query->execute(
        array(
          $data['dni']
        )
      );
      return $query->fetchall(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
      die($e->getCode());
    }
  }
}
