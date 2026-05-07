<?php
require_once 'db.php';    
$totalDoctores  = $pdo->query("SELECT COUNT(*) FROM doctores")->fetchColumn();
$totalPacientes = $pdo->query("SELECT COUNT(*) FROM pacientes")->fetchColumn();
$ultimosPacientes = $pdo->query("
    SELECT p.nombre, p.edad, d.nombre AS doctor, d.especialidad
    FROM pacientes p
    JOIN doctores d ON p.doctor_id = d.id
    ORDER BY p.created_at DESC LIMIT 5
")->fetchAll(PDO::FETCH_ASSOC);
?>
<?php require_once 'header.php'; ?>

<div class="main">
    <div class="topbar">
        <h5><i class="fas fa-house me-2"></i>Inicio</h5>
        <small><?= date('d/m/Y H:i') ?></small>
    </div>
    <div class="content">

        <!-- STATS -->
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card p-4 d-flex flex-row align-items-center gap-3">
                    <div style="width:56px;height:56px;border-radius:14px;background:rgba(26,60,94,.1);
                        display:flex;align-items:center;justify-content:center;font-size:1.5rem;color:#1a3c5e;">
                        <i class="fas fa-user-md"></i>
                    </div>
                    <div>
                        <div style="font-size:2rem;font-weight:700;"><?= $totalDoctores ?></div>
                        <div style="color:#7a8fa6;font-size:.85rem;">Doctores registrados</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-4 d-flex flex-row align-items-center gap-3">
                    <div style="width:56px;height:56px;border-radius:14px;background:rgba(232,160,32,.12);
                        display:flex;align-items:center;justify-content:center;font-size:1.5rem;color:#e8a020;">
                        <i class="fas fa-hospital-user"></i>
                    </div>
                    <div>
                        <div style="font-size:2rem;font-weight:700;"><?= $totalPacientes ?></div>
                        <div style="color:#7a8fa6;font-size:.85rem;">Pacientes atendidos</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-4 d-flex flex-row align-items-center gap-3">
                    <div style="width:56px;height:56px;border-radius:14px;background:rgba(46,158,107,.12);
                        display:flex;align-items:center;justify-content:center;font-size:1.5rem;color:#2e9e6b;">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div>
                        <div style="font-size:2rem;font-weight:700;"><?= date('d/m') ?></div>
                        <div style="color:#7a8fa6;font-size:.85rem;">Fecha de hoy</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ACCESOS RÁPIDOS -->
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <div class="card p-4 text-center">
                    <i class="fas fa-user-md fa-2x mb-3" style="color:#1a3c5e;"></i>
                    <h6 class="fw-semibold">Gestión de Doctores</h6>
                    <p class="text-muted small">Registrar, editar, ver y eliminar doctores con foto de perfil.</p>
                    <a href="doctores/index.php" class="btn btn-primary btn-sm mt-1">
                        <i class="fas fa-arrow-right me-1"></i>Ir a Doctores
                    </a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card p-4 text-center">
                    <i class="fas fa-hospital-user fa-2x mb-3" style="color:#e8a020;"></i>
                    <h6 class="fw-semibold">Gestión de Pacientes</h6>
                    <p class="text-muted small">Registrar pacientes y asignarlos a sus doctores correspondientes.</p>
                    <a href="pacientes/index.php" class="btn btn-warning btn-sm mt-1">
                        <i class="fas fa-arrow-right me-1"></i>Ir a Pacientes
                    </a>
                </div>
            </div>
        </div>

        <!-- ÚLTIMOS PACIENTES -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span class="fw-semibold"><i class="fas fa-clock me-2"></i>Últimos Pacientes Registrados</span>
                <a href="pacientes/index.php" class="btn btn-sm btn-primary">Ver todos</a>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Paciente</th>
                            <th>Edad</th>
                            <th>Doctor</th>
                            <th>Especialidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($ultimosPacientes as $p): ?>
                        <tr>
                            <td class="ps-4 fw-medium"><?= htmlspecialchars($p['nombre']) ?></td>
                            <td><?= $p['edad'] ?> años</td>
                            <td><?= htmlspecialchars($p['doctor']) ?></td>
                            <td><span class="badge-esp"><?= htmlspecialchars($p['especialidad']) ?></span></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<?php require_once 'footer.php'; ?>