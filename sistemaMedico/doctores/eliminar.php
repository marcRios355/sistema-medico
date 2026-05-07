<?php
require_once '../db.php';
$id = (int)$_GET['id'];

// 1. Obtener info para borrar la foto
$stmt = $pdo->prepare("SELECT foto FROM doctores WHERE id = ?");
$stmt->execute([$id]);
$doc = $stmt->fetch();

if ($doc) {
    if ($doc['foto'] && file_exists('../uploads/' . $doc['foto'])) {
        unlink('../uploads/' . $doc['foto']);
    }
    // 2. Eliminar registro
    $stmt = $pdo->prepare("DELETE FROM doctores WHERE id = ?");
    $stmt->execute([$id]);
}

header("Location: index.php?msg=eliminado");
exit;