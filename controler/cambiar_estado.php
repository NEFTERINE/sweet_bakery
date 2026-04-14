<?php
require_once 'conexion.php';

$id = $_GET['id'];

$stmt = $pdo->prepare("UPDATE usuarios 
    SET estatus = IF(estatus='activo','inactivo','activo') 
    WHERE id = ?");
$stmt->execute([$id]);

header('Location: ../usuarios.php');
exit;

?>