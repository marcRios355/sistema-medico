<?php
require_once '../db.php';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre       = trim($_POST['nombre']);
    $especialidad = trim($_POST['especialidad']);
    $telefono     = trim($_POST['telefono']);
    $email        = trim($_POST['email']);
    $foto         = null;

    // Directorio de subida (sube un nivel desde doctores/ hacia la raíz)
    $uploadDir = '../uploads/';
    
    // Crear la carpeta si no existe
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    if (!empty($_FILES['foto']['name'])) {
        $file     = $_FILES['foto'];
        $ext      = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowed  = ['jpg', 'jpeg', 'png', 'webp'];
        
        if (!in_array($ext, $allowed)) {
            $error = 'Formato no permitido. Usa JPG, PNG o WEBP.';
        } elseif ($file['size'] > 2 * 1024 * 1024) {
            $error = 'La imagen es demasiado pesada (Máx 2MB).';
        } else {
            $foto = 'doc_' . uniqid() . '.' . $ext;
            $targetPath = $uploadDir . $foto;
            
            if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
                $error = 'Error al mover el archivo al servidor.';
            }
        }
    }

    if (!$error && $nombre && $especialidad) {
        $stmt = $pdo->prepare("INSERT INTO doctores (nombre, especialidad, telefono, email, foto) VALUES (?,?,?,?,?)");
        $stmt->execute([$nombre, $especialidad, $telefono, $email, $foto]);
        header("Location: index.php?msg=creado");
        exit;
    }
}
?>