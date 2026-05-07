<?php
require_once '../db.php';

$id = (int)($_GET['id'] ?? 0);
$error = '';

// 1. Obtener los datos actuales del paciente
$stmt = $pdo->prepare("SELECT * FROM pacientes WHERE id = ?");
$stmt->execute([$id]);
$p = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$p) {
    header("Location: index.php");
    exit;
}

// 2. Obtener lista de doctores para el selector (dropdown)
$doctores = $pdo->query("SELECT id, nombre FROM doctores ORDER BY nombre ASC")->fetchAll(PDO::FETCH_ASSOC);

// 3. Procesar el formulario de actualización
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre      = trim($_POST['nombre']);
    $edad        = (int)$_POST['edad'];
    $doctor_id   = (int)$_POST['doctor_id'];
    $diagnostico = trim($_POST['diagnostico']);

    if (empty($nombre) || $edad <= 0 || $doctor_id <= 0) {
        $error = "Por favor, completa todos los campos obligatorios.";
    } else {
        $sql = "UPDATE pacientes SET nombre = ?, edad = ?, doctor_id = ?, diagnostico = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        
        if ($stmt->execute([$nombre, $edad, $doctor_id, $diagnostico, $id])) {
            header("Location: index.php?msg=editado");
            exit;
        } else {
            $error = "Error al intentar actualizar los datos.";
        }
    }
}

require_once '../header.php';
?>

<div class="main">
    <div class="topbar">
        <h5><i class="fas fa-user-edit me-2"></i>Editar Paciente</h5>
    </div>

    <div class="content">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <?php if ($error): ?>
                            <div class="alert alert-danger"><?= $error ?></div>
                        <?php endif; ?>

                        <form method="POST">
                            <div class="row">
                                <div class="col-md-8 mb-3">
                                    <label class="form-label fw-medium">Nombre Completo</label>
                                    <input type="text" name="nombre" class="form-control" 
                                           value="<?= htmlspecialchars($p['nombre']) ?>" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-medium">Edad</label>
                                    <input type="number" name="edad" class="form-control" 
                                           value="<?= htmlspecialchars($p['edad']) ?>" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-medium">Doctor Asignado</label>
                                <select name="doctor_id" class="form-select" required>
                                    <option value="">Seleccione un doctor...</option>
                                    <?php foreach ($doctores as $doc): ?>
                                        <option value="<?= $doc['id'] ?>" <?= ($doc['id'] == $p['doctor_id']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($doc['nombre']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-medium">Diagnóstico / Observaciones</label>
                                <textarea name="diagnostico" class="form-control" rows="4"><?= htmlspecialchars($p['diagnostico']) ?></textarea>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-warning px-4">
                                    <i class="fas fa-save me-1"></i> Actualizar Cambios
                                </button>
                                <a href="index.php" class="btn btn-outline-secondary px-4">Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once '../footer.php'; ?>