<?php

require_once 'conexion.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

$response = ['logged_in' => false];

if (isset($_SESSION['usuario_id'])) {
    $response['logged_in'] = true;
    $response['usuario_id'] = $_SESSION['usuario_id'];
    $response['usuario_nombre'] = $_SESSION['usuario_nombre'];
}

echo json_encode($response);
?>