<?php
require_once 'Conexion.php';

class Mascota  extends Conexion
{
  private $conexion;

  public function __construct()
  {
    $this->conexion = parent::getConexion();
  }

  public function add($data = [])
  {
    try {
      $query = $this->conexion->prepare("CALL spu_mascotas_add(?,?,?,?,?,?)");
      $query->execute(
        array(
          $data['idcliente'],
          $data['idraza'],
          $data['nombre'],
          $data['fotografia'],
          $data['color'],
          $data['genero']
        )
      );
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  public function searchPetOwner($data = [])
  {
    try {
      $query = $this->conexion->prepare("CALL spu_buscar_mascota_cliente(?)");
      $query->execute(
        array(
          $data['dni']
        )
      );
      return $query->fetchall(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }
  

  public function searchPet($data = [])
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
      die($e->getMessage());
    }
  }

  public function listRace()
  {
    try {
      $query = $this->conexion->prepare("CALL spu_razas_listar()");
      $query->execute();
      return $query->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }
}
