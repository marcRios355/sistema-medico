<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediFAST – Sistema Médico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary:#1a3c5e; --accent:#e8a020; --light:#f4f7fb;
            --card:#fff; --text:#1e2d3d; --muted:#7a8fa6; --border:#dce6f0;
        }
        body { font-family:'DM Sans',sans-serif; background:var(--light); color:var(--text); margin:0; }
        /* SIDEBAR */
        .sidebar {
            width:250px; background:var(--primary); min-height:100vh;
            position:fixed; top:0; left:0; z-index:200;
            box-shadow:4px 0 20px rgba(0,0,0,.18);
        }
        .sidebar-brand { padding:28px 22px; border-bottom:1px solid rgba(255,255,255,.1); }
        .sidebar-brand h2 { font-family:'Playfair Display',serif; color:#fff; font-size:1.5rem; }
        .sidebar-brand h2 span { color:var(--accent); }
        .sidebar-brand small { color:rgba(255,255,255,.4); font-size:.75rem; }
        .nav-label { color:rgba(255,255,255,.3); font-size:.65rem; letter-spacing:2px;
            text-transform:uppercase; padding:18px 22px 6px; }
        .sidebar a {
            display:flex; align-items:center; gap:11px; padding:11px 22px;
            color:rgba(255,255,255,.65); text-decoration:none; font-size:.88rem;
            transition:.2s; border-left:3px solid transparent;
        }
        .sidebar a:hover, .sidebar a.active {
            background:rgba(255,255,255,.08); color:#fff;
            border-left-color:var(--accent);
        }
        .sidebar a i { width:18px; text-align:center; }
        /* MAIN */
        .main { margin-left:250px; }
        .topbar {
            background:#fff; padding:16px 32px; border-bottom:1px solid var(--border);
            display:flex; align-items:center; justify-content:space-between;
            position:sticky; top:0; z-index:100;
        }
        .topbar h5 { font-weight:600; margin:0; font-size:1rem; }
        .topbar small { color:var(--muted); font-size:.8rem; }
        .content { padding:30px 32px; }
        /* CARDS */
        .card { border:1px solid var(--border); border-radius:14px; box-shadow:0 2px 12px rgba(0,0,0,.04); }
        .card-header { background:#fff; border-bottom:1px solid var(--border);
            border-radius:14px 14px 0 0 !important; padding:16px 22px; }
        .btn-primary { background:var(--primary); border-color:var(--primary); }
        .btn-primary:hover { background:#142e4a; border-color:#142e4a; }
        .btn-warning { color:#fff; background:var(--accent); border-color:var(--accent); }
        .btn-warning:hover { background:#c98818; border-color:#c98818; color:#fff; }
        .table th { font-size:.8rem; text-transform:uppercase; letter-spacing:.5px;
            color:var(--muted); font-weight:600; border-top:none; }
        .table td { vertical-align:middle; font-size:.9rem; }
        .badge-esp { background:rgba(26,60,94,.1); color:var(--primary);
            padding:4px 10px; border-radius:20px; font-size:.78rem; font-weight:500; }
        .foto-thumb { width:44px; height:44px; border-radius:50%; object-fit:cover;
            border:2px solid var(--border); }
        .foto-placeholder {
            width:44px; height:44px; border-radius:50%; background:rgba(26,60,94,.1);
            display:inline-flex; align-items:center; justify-content:center;
            color:var(--primary); font-size:1.1rem; }
        .alert { border-radius:10px; font-size:.88rem; }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="sidebar-brand">
        <h2>Medi<span>FAST</span></h2>
        <small>Sistema de Gestión Médica</small>
    </div>
    <div class="mt-2">
        <div class="nav-label">Menú Principal</div>
        <a href="../index.php"><i class="fas fa-house"></i> Inicio</a>
        <div class="nav-label">Gestión</div>
        <a href="../doctores/index.php"><i class="fas fa-user-md"></i> Doctores</a>
        <a href="../pacientes/index.php"><i class="fas fa-hospital-user"></i> Pacientes</a>
    </div>
</div>