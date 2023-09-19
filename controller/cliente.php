<?php
require_once '../model/cliente.model.php';

$cliente = new Cliente();

if(isset($_POST['operacion'])){
  if($_POST['operacion']=='add'){
    $password = $_POST['claveacceso'];
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT); // Genera el hash del password

    $registro =[
      "apellidos" => $_POST['apellidos'],
      "nombres" => $_POST['nombres'],
      "dni" => $_POST['dni'],
      "claveacceso" => $hashedPassword // Guarda el hash en la base de datos
    ];

    $cliente->add($registro);
  }  
}

if(isset($_GET['operacion'])){
  if($_GET['operacion']=='search'){
    echo json_encode($cliente->search(["dni" => $_GET['dni']]));
  }  
}
?>
