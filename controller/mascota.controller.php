<?php
require_once '../model/mascota.model.php';

$mascota = new Mascota();

if(isset($_POST['operacion'])){
  
  if($_POST['operacion']=='add'){
    
    $uploadDirectory = "";
    $uploadFilename = "";
    $uploadFilepath = "";
  
    if ($_POST['fotografia'] != ""){
      $uploadDirectory = "../image/";
      $uploadFilename = sha1(date('c')). '.jpg';
      $uploadFilepath = $uploadDirectory . $uploadFilename;
  
      file_put_contents($uploadFilepath, base64_decode($_POST['fotografia']));
    }
    $registro =[
      "idcliente" =>$_POST['idcliente'],
      "idraza"=>$_POST['idraza'],
      "nombre"=>$_POST['nombreMascota'],
      "fotografia" => $uploadFilename,
      "color"=>$_POST['color'],
      "genero"=>$_POST['genero']
    ];
    $mascota->add($registro);
  }
}

if(isset($_GET['operacion'])){

  if($_GET['operacion']=='search'){
    echo json_encode($mascota->searchPet($_GET['idmascota']));
  } 
  
  if($_GET['operacion']== 'searchPetOwner'){
    echo json_encode($mascota->searchPetOwner($_GET['dni']));
  } 

  if($_GET['operacion']=='listRace'){
    echo json_encode($mascota->listRace());
  } 
}

