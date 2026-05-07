<?php
require_once '../db.php';
$msg = $_GET['msg'] ?? '';
$doctores = $pdo->query("SELECT * FROM doctores ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<?php require_once '../header.php'; ?>

<div class="main">
    <div class="topbar">
        <h5><i class="fas fa-user-md me-2"></i>Doctores</h5>
        <small><?= date('d/m/Y H:i') ?></small>
    </div>
    <div class="content">

        <?php if ($msg === 'creado'): ?>
            <div class="alert alert-success"><i class="fas fa-check-circle me-2"></i>Doctor registrado correctamente.</div>
        <?php elseif ($msg === 'editado'): ?>
            <div class="alert alert-info"><i class="fas fa-check-circle me-2"></i>Doctor actualizado correctamente.</div>
        <?php elseif ($msg === 'eliminado'): ?>
            <div class="alert alert-warning"><i class="fas fa-trash me-2"></i>Doctor eliminado.</div>
        <?php endif; ?>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span class="fw-semibold">Lista de Doctores</span>
                <a href="crear.php" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus me-1"></i> Nuevo Doctor
                </a>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">#</th>
                            <th>Foto</th>
                            <th>Nombre</th>
                            <th>Especialidad</th>
                            <th>Teléfono</th>
                            <th>Email</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($doctores as $d): ?>
                        <tr>
                            <td class="ps-4 text-muted"><?= $d['id'] ?></td>
                            <td>
                                <?php if ($d['foto'] && file_exists('../uploads/' . $d['foto'])): ?>
                                    <img src="../uploads/<?= htmlspecialchars($d['foto']) ?>" class="foto-thumb" alt="foto">
                                <?php else: ?>
                                    <div class="foto-placeholder"><i class="fas fa-user-md"></i></div>
                                <?php endif; ?>
                            </td>
                            <td class="fw-medium"><?= htmlspecialchars($d['nombre']) ?></td>
                            <td><span class="badge-esp"><?= htmlspecialchars($d['especialidad']) ?></span></td>
                            <td><?= htmlspecialchars($d['telefono'] ?? '—') ?></td>
                            <td><?= htmlspecialchars($d['email'] ?? '—') ?></td>
                            <td class="text-center">
                                <a href="ver.php?id=<?= $d['id'] ?>" class="btn btn-sm btn-outline-secondary" title="Ver">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="editar.php?id=<?= $d['id'] ?>" class="btn btn-sm btn-warning" title="Editar">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <a href="eliminar.php?id=<?= $d['id'] ?>" class="btn btn-sm btn-danger" title="Eliminar"
                                   onclick="return confirm('¿Eliminar a <?= addslashes($d['nombre']) ?>? Esto también eliminará sus pacientes.')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if (empty($doctores)): ?>
                        <tr><td colspan="7" class="text-center text-muted py-4">No hay doctores registrados.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once '../footer.php'; ?>