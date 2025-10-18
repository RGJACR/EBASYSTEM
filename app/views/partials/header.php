<?php
// Asegurarse de que la sesión esté iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Si NO hay usuario logueado y estás en la vista de login, no cargar el header completo
$pagina_actual = $_GET['a'] ?? '';
?>


<!doctype html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>SISTEMA DE GESTION MULTIEBA</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
</head>
<body class="hold-transition sidebar-mini">

	<?php 
	if (empty($_SESSION['user']) && $pagina_actual === 'login') {
	    return; // detenemos aquí: no mostrar el header.php
	}
	?>

	<div class="wrapper">

		<nav class="main-header navbar navbar-expand navbar-white navbar-light">
			<ul class="navbar-nav">
				<li class="nav-item"><a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a></li>
			</ul>
			<ul class="navbar-nav ml-auto">
				<?php if(!empty($_SESSION['user'])): ?>
				<li class="nav-item dropdown"><a class="nav-link" data-toggle="dropdown" href="#"><img src="<?=htmlspecialchars($_SESSION['user']['avatar'] ?? 'public/img/avatars/default.png')?>" class="img-circle" style="width:32px;height:32px;object-fit:cover"> <?=htmlspecialchars($_SESSION['user']['nombre'])?></a>
					<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right"><a href="index.php?c=Auth&a=profile" class="dropdown-item">Editar perfil</a>
						<div class="dropdown-divider"></div><a href="index.php?c=Auth&a=logout" class="dropdown-item">Salir</a></div>
				</li>
				<?php endif; ?>
			</ul>
		</nav>

		<aside class="main-sidebar sidebar-dark-primary elevation-4"><a href="index.php" class="brand-link" style="text-align: center;"><span class="brand-text font-weight-light" style="white-space: normal !important;">SISTEMA DE GESTION MULTIEBA </span></a>
			<div class="sidebar">
				<?php if(!empty($_SESSION['user'])): ?>
				<div class="user-panel mt-3 pb-3 mb-3 d-flex">
					<div class="image"><img src="<?=htmlspecialchars($_SESSION['user']['avatar'] ?? 'public/img/avatars/default.png')?>" class="img-circle elevation-2" alt="User Image"></div>
					<div class="info">
						<a href="index.php?c=Auth&a=profile" class="d-block">
							<?=htmlspecialchars($_SESSION['user']['nombre'])?>
						</a><small class="text-muted"><?=htmlspecialchars($_SESSION['user']['rol'])?></small></div>
				</div>
				<?php endif; ?>
				<nav class="mt-2">
					<ul class="nav nav-pills nav-sidebar flex-column" role="menu">

						<?php if(empty($_SESSION['user'])): ?>
						<li class="nav-item">
							<a href="index.php?c=Auth&a=login" class="nav-link"><i class="nav-icon fas fa-sign-in-alt"></i><p>Login</p></a>
						</li>

						<?php else: ?>
						<?php if(strtoupper($_SESSION['user']['rol']) === 'ADMINISTRADOR'): ?>
						<li class="nav-item">
							<a href="index.php?c=Admin&a=index" class="nav-link"><i class="nav-icon fas fa-chart-pie"></i><p>Dashboard</p></a></li>
						<li class="nav-item"><a href="index.php?c=Admin&a=users" class="nav-link"><i class="nav-icon fas fa-users"></i><p>Usuarios</p></a></li>
						<li class="nav-item"><a href="index.php?c=Admin&a=evaluaciones" class="nav-link"><i class="nav-icon fas fa-star"></i><p>Evaluación Directores</p></a></li>
						<?php endif; ?>
						<?php if(strtoupper($_SESSION['user']['rol']) === 'DIRECTOR'): ?>
						<li class="nav-item"><a href="index.php?c=Director&a=index" class="nav-link"><i class="nav-icon fas fa-user-tie"></i><p>Gestión Director</p></a></li>
						<li class="nav-item"><a href="index.php?c=Director&a=estudiantes" class="nav-link"><i class="nav-icon fas fa-users"></i><p>Estudiantes</p></a></li>
						<li class="nav-item"><a href="index.php?c=Director&a=crear_docente" class="nav-link"><i class="nav-icon fas fa-chalkboard-teacher"></i><p>Plana Docente</p></a></li>
						<li class="nav-item"><a href="index.php?c=Director&a=evaluaciones" class="nav-link"><i class="nav-icon fas fa-clipboard-list"></i><p>Evaluaciones</p></a></li>
						<?php endif; ?>
						<?php if(strtoupper($_SESSION['user']['rol']) === 'DOCENTE'): ?>
						<li class="nav-item"><a href="index.php?c=Docente&a=index" class="nav-link"><i class="nav-icon fas fa-chalkboard-teacher"></i><p>Gestión Docente</p></a></li>
						<li class="nav-item"><a href="index.php?c=Docente&a=pedagogica" class="nav-link"><i class="nav-icon fas fa-file-upload"></i><p>Pedagógica</p></a></li>
						<li class="nav-item"><a href="index.php?c=Docente&a=socio" class="nav-link"><i class="nav-icon fas fa-users"></i><p>Gestión Socio Económica</p></a></li>
						<li class="nav-item"><a href="index.php?c=Docente&a=estrategica" class="nav-link"><i class="nav-icon fas fa-chart-line"></i><p>Estrategica</p></a></li>
						<?php endif; ?>
						<?php endif; ?>
					</ul>
				</nav>
			</div>
		</aside>

	<div class="content-wrapper p-3">