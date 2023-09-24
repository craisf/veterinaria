<?php
require_once '../model/mascota.model.php';

$mascota = new Mascota();

if(isset($_POST['operacion'])){
  if($_POST['operacion']=='add'){
    $registro =[
      "idcliente" =>$_POST['idcliente'],
      "idraza"=>$_POST['idraza'],
      "nombre"=>$_POST['nombre'],
      "color"=>$_POST['color'],
      "genero"=>$_POST['genero']
    ];
    $mascota->add($registro);
  }
}

if(isset($_GET['operacion'])){
  if($_GET['operacion']=='search'){
    echo json_encode($mascota->searchPet(["idmascota" => $_GET['idmascota']]));
  }  
}