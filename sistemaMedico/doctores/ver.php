<?php
require_once '../db.php';
$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM doctores WHERE id = ?");
$stmt->execute([$id]);
$d = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$d) { header("Location: index.php"); exit; }

$pacientes = $pdo->prepare("SELECT * FROM pacientes WHERE doctor_id = ? ORDER BY created_at DESC");
$pacientes->execute([$id]);
$pacs = $pacientes->fetchAll(PDO::FETCH_ASSOC);
?>
<?php require_once '../header.php'; ?>

<div class="main">
    <div class="topbar">
        <h5><i class="fas fa-eye me-2"></i>Detalle del Doctor</h5>
        <small><?= date('d/m/Y H:i') ?></small>
    </div>
    <div class="content">
        <div class="row g-4">
            <!-- Perfil -->
            <div class="col-md-4">
                <div class="card p-4 text-center">
                    <?php if ($d['foto'] && file_exists('../uploads/' . $d['foto'])): ?>
                        <img src="../uploads/<?= htmlspecialchars($d['foto']) ?>"
                            style="width:110px;height:110px;border-radius:50%;object-fit:cover;
                                   border:3px solid #dce6f0;margin:0 auto 16px;" alt="foto">
                    <?php else: ?>
                        <div style="width:110px;height:110px;border-radius:50%;background:rgba(26,60,94,.1);
                            display:flex;align-items:center;justify-content:center;
                            font-size:2.8rem;color:#1a3c5e;margin:0 auto 16px;">
                            <i class="fas fa-user-md"></i>
                        </div>
                    <?php endif; ?>
                    <h5 class="fw-bold mb-1"><?= htmlspecialchars($d['nombre']) ?></h5>
                    <span class="badge-esp"><?= htmlspecialchars($d['especialidad']) ?></span>
                    <hr class="my-3">
                    <?php if ($d['telefono']): ?>
                    <div class="d-flex align-items-center gap-2 mb-2" style="font-size:.88rem;">
                        <i class="fas fa-phone text-muted"></i>
                        <span><?= htmlspecialchars($d['telefono']) ?></span>
                    </div>
                    <?php endif; ?>
                    <?php if ($d['email']): ?>
                    <div class="d-flex align-items-center gap-2 mb-2" style="font-size:.88rem;">
                        <i class="fas fa-envelope text-muted"></i>
                        <span><?= htmlspecialchars($d['email']) ?></span>
                    </div>
                    <?php endif; ?>
                    <div class="mt-3 d-flex gap-2 justify-content-center">
                        <a href="editar.php?id=<?= $d['id'] ?>" class="btn btn-warning btn-sm">
                            <i class="fas fa-pen me-1"></i>Editar
                        </a>
                        <a href="index.php" class="btn btn-outline-secondary btn-sm">Volver</a>
                    </div>
                </div>
            </div>
            <!-- Pacientes -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span class="fw-semibold">Pacientes asignados (<?= count($pacs) ?>)</span>
                        <a href="../pacientes/crear.php?doctor_id=<?= $d['id'] ?>" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus me-1"></i>Agregar Paciente
                        </a>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Nombre</th>
                                    <th>Edad</th>
                                    <th>Diagnóstico</th>
                                    <th>Fecha</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pacs as $p): ?>
                                <tr>
                                    <td class="ps-4 fw-medium"><?= htmlspecialchars($p['nombre']) ?></td>
                                    <td><?= $p['edad'] ?> años</td>
                                    <td style="max-width:160px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                        <?= htmlspecialchars($p['diagnostico'] ?? '—') ?>
                                    </td>
                                    <td><?= $p['fecha_registro'] ?></td>
                                    <td>
                                        <a href="../pacientes/editar.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-warning">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <a href="../pacientes/eliminar.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-danger"
                                           onclick="return confirm('¿Eliminar paciente?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php if (empty($pacs)): ?>
                                <tr><td colspan="5" class="text-center text-muted py-4">Sin pacientes asignados.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once '../footer.php'; ?>