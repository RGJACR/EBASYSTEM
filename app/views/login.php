<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SISTEMA DE GESTIÓN MULTIEBA</title>

  <!-- ✅ Estilos esenciales (sin sidebar, sin layout completo) -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">
</head>

<body class="hold-transition login-page" 
      style="background-image:url('https://www.ugel10huaral.gob.pe/images/Imagen_de_WhatsApp_20250315_a_las_210215_5b2eb7d2.jpg');
             background-size:cover; background-position:center;">

  <div class="login-box">
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a class="h1"><b>SISTEMA DE GESTIÓN MULTIEBA</b></a>
      </div>
      <div class="card-body">
        <p class="login-box-msg">Inicia sesión para comenzar</p>

        <?php if (!empty($error)): ?>
          <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="post" action="index.php?c=Auth&a=login">
          <div class="input-group mb-3">
            <input type="email" name="email" class="form-control" placeholder="Correo" required>
            <div class="input-group-append">
              <div class="input-group-text"><span class="fas fa-envelope"></span></div>
            </div>
          </div>

          <div class="input-group mb-3">
            <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
            <div class="input-group-append">
              <div class="input-group-text"><span class="fas fa-lock"></span></div>
            </div>
          </div>

          <div class="row">
            <div class="col-12">
              <button type="submit" class="btn btn-primary btn-block">Entrar</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- ✅ Scripts necesarios -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>
