<?php
$host     = "localhost";
$dbname   = "sistema_medico";
$user     = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("<div style='font-family:sans-serif;padding:20px;color:red;'>
        <h3>Error de conexión</h3><p>" . $e->getMessage() . "</p>
        <p>Asegúrate de haber ejecutado <b>setup.sql</b> en phpMyAdmin.</p></div>");
}
?>