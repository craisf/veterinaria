<?php
require_once 'Conexion.php';

class Cliente   extends Conexion
{
  private $conexion;

  public function __construct()
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

  public function search($data = [])
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
