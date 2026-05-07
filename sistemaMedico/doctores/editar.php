<?php
require_once '../db.php';
$id    = (int)($_GET['id'] ?? 0);
$error = '';

$stmt = $pdo->prepare("SELECT * FROM doctores WHERE id = ?");
$stmt->execute([$id]);
$d = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$d) { header("Location: index.php"); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre       = trim($_POST['nombre']);
    $especialidad = trim($_POST['especialidad']);
    $telefono     = trim($_POST['telefono']);
    $email        = trim($_POST['email']);
    $foto         = $d['foto'];

    if (!empty($_FILES['foto']['name'])) {
        $ext     = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg','jpeg','png','gif','webp'];
        if (!in_array($ext, $allowed)) {
            $error = 'Solo se permiten imágenes JPG, PNG, GIF o WEBP.';
        } elseif ($_FILES['foto']['size'] > 2 * 1024 * 1024) {
            $error = 'La imagen no debe superar 2MB.';
        } else {
            // Eliminar foto anterior
            if ($d['foto'] && file_exists('../uploads/' . $d['foto'])) {
                unlink('../uploads/' . $d['foto']);
            }
            $foto = uniqid('doc_') . '.' . $ext;
            move_uploaded_file($_FILES['foto']['tmp_name'], '../uploads/' . $foto);
        }
    }

    if (!$error && $nombre && $especialidad) {
        $stmt = $pdo->prepare("UPDATE doctores SET nombre=?, especialidad=?, telefono=?, email=?, foto=? WHERE id=?");
        $stmt->execute([$nombre, $especialidad, $telefono, $email, $foto, $id]);
        header("Location: index.php?msg=editado");
        exit;
    } elseif (!$error) {
        $error = 'Nombre y especialidad son obligatorios.';
    }
    // Actualizar $d con los datos enviados para repoblar el form
    $d = array_merge($d, $_POST);
}
?>
<?php require_once '../header.php'; ?>

<div class="main">
    <div class="topbar">
        <h5><i class="fas fa-pen me-2"></i>Editar Doctor</h5>
        <small><?= date('d/m/Y H:i') ?></small>
    </div>
    <div class="content">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="card">
                    <div class="card-header fw-semibold">
                        <i class="fas fa-user-md me-2"></i>Editar: <?= htmlspecialchars($d['nombre']) ?>
                    </div>
                    <div class="card-body p-4">
                        <?php if ($error): ?>
                            <div class="alert alert-danger"><?= $error ?></div>
                        <?php endif; ?>

                        <!-- Foto actual -->
                        <?php if ($d['foto'] && file_exists('../uploads/' . $d['foto'])): ?>
                        <div class="mb-3 text-center">
                            <img src="../uploads/<?= htmlspecialchars($d['foto']) ?>"
                                style="width:90px;height:90px;border-radius:50%;object-fit:cover;border:3px solid #dce6f0;" alt="foto">
                            <div class="text-muted small mt-1">Foto actual</div>
                        </div>
                        <?php endif; ?>

                        <form method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label class="form-label fw-medium">Nombre completo <span class="text-danger">*</span></label>
                                <input type="text" name="nombre" class="form-control"
                                    value="<?= htmlspecialchars($d['nombre']) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-medium">Especialidad <span class="text-danger">*</span></label>
                                <input type="text" name="especialidad" class="form-control"
                                    value="<?= htmlspecialchars($d['especialidad']) ?>" required>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-medium">Teléfono</label>
                                    <input type="text" name="telefono" class="form-control"
                                        value="<?= htmlspecialchars($d['telefono'] ?? '') ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-medium">Email</label>
                                    <input type="email" name="email" class="form-control"
                                        value="<?= htmlspecialchars($d['email'] ?? '') ?>">
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-medium">Nueva foto (opcional)</label>
                                <input type="file" name="foto" class="form-control" accept="image/*">
                                <div class="form-text">Dejar vacío para mantener la foto actual.</div>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-save me-1"></i>Actualizar Doctor
                                </button>
                                <a href="index.php" class="btn btn-outline-secondary">Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once '../footer.php'; ?>