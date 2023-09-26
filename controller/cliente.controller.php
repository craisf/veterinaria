<?php
require_once '../model/cliente.model.php';

$cliente = new Cliente();

if (isset($_POST['operacion'])) {

  if ($_POST['operacion'] == 'add') {
    $password = $_POST['claveacceso'];
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT); // Genera el hash del password

    $data = [
      "apellidos" => $_POST['apellidos'],
      "nombres" => $_POST['nombres'],
      "dni" => $_POST['dni'],
      "claveacceso" => $hashedPassword // Guarda el hash en la base de datos
    ];
    $cliente->add($data);
  }

  if ($_POST['operacion'] == 'login') {
    $response = [
      "login"       => false,
      "idcliente"   => "",
      "apellidos"   => "",
      "nombres"     => ""
    ];

    $result = $cliente->login($_POST['username']);
    $passwordInput = $_POST['password'];

    if ($result && password_verify($passwordInput, $result['claveacceso'])) {
      $response['login'] = true;
      $response['idcliente'] = $result['idcliente'];
      $response['apellidos'] = $result['apellidos'];
      $response['nombres'] = $result['nombres'];
    } else {
      $response['message'] = 'Credenciales inválidas';
    }

    echo json_encode($response);
  }
}

if (isset($_GET['operacion'])) {
  if ($_GET['operacion'] == 'search') {
    echo json_encode($cliente->searchDNI(["dni" => $_GET['dni']]));
  }
}
