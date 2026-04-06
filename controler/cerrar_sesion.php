<?php
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Cerrando sesión...</title>
    <script>
        // Limpiar localStorage al cerrar sesión
        localStorage.removeItem('sweetBakeryGame');
        window.location.href = '../cocina.php';
    </script>
</head>
<body>
    <p>Cerrando sesión...</p>
</body>
</html>
<?php
exit;
?>