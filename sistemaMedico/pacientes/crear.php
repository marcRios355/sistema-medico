<?php
require_once '../db.php';
$doctores = $pdo->query("SELECT id, nombre FROM doctores")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("INSERT INTO pacientes (nombre, edad, doctor_id, diagnostico) VALUES (?,?,?,?)");
    $stmt->execute([$_POST['nombre'], $_POST['edad'], $_POST['doctor_id'], $_POST['diagnostico']]);
    header("Location: index.php");
}
require_once '../header.php';
?>
<div class="main">
    <div class="content">
        <div class="card col-md-6 mx-auto">
            <div class="card-header fw-bold">Registrar Nuevo Paciente</div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label>Nombre Completo</label>
                        <input type="text" name="nombre" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Edad</label>
                        <input type="number" name="edad" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Asignar Doctor</label>
                        <select name="doctor_id" class="form-select" required>
                            <?php foreach($doctores as $d): ?>
                                <option value="<?= $d['id'] ?>"><?= htmlspecialchars($d['nombre']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Diagnóstico Inicial</label>
                        <textarea name="diagnostico" class="form-control" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Guardar Paciente</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php require_once '../footer.php'; ?>