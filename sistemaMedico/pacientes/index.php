<?php
require_once '../db.php';
$stmt = $pdo->query("
    SELECT p.*, d.nombre AS doctor_nombre 
    FROM pacientes p 
    JOIN doctores d ON p.doctor_id = d.id 
    ORDER BY p.id DESC
");
$pacientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
require_once '../header.php';
?>

<div class="main">
    <div class="topbar">
        <h5><i class="fas fa-hospital-user me-2"></i>Gestión de Pacientes</h5>
        <a href="crear.php" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Nuevo Paciente</a>
    </div>
    <div class="content">
        <div class="card">
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">ID</th>
                            <th>Nombre</th>
                            <th>Edad</th>
                            <th>Doctor Asignado</th>
                            <th>Fecha Registro</th>
                            <th class="text-end pe-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pacientes as $p): ?>
                        <tr>
                            <td class="ps-4 text-muted">#<?= $p['id'] ?></td>
                            <td class="fw-medium"><?= htmlspecialchars($p['nombre']) ?></td>
                            <td><?= $p['edad'] ?> años</td>
                            <td><span class="badge-esp"><?= htmlspecialchars($p['doctor_nombre']) ?></span></td>
                            <td><?= date('d/m/Y', strtotime($p['created_at'])) ?></td>
                            <td class="text-end pe-4">
                                <a href="editar.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-warning"><i class="fas fa-pen"></i></a>
                                <a href="eliminar.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Borrar paciente?')"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php require_once '../footer.php'; ?>