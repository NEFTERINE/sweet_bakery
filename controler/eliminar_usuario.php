<?php
require_once 'conexion.php';

$id = $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = ?");
$stmt->execute([$id]);

header('Location: ../usuarios.php');
exit;

?>