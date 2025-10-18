<h2>Editar perfil</h2>
<form method="post" action="index.php?c=Auth&a=update_profile" enctype="multipart/form-data">
  <div class="row">
    <div class="col-md-3">
      <img src="<?=htmlspecialchars($user['avatar'] ?? 'public/img/avatars/default.png')?>" class="img-fluid rounded mb-2" alt="avatar">
      <div class="mb-2"><label>Subir foto</label><input type="file" name="avatar" class="form-control"></div>
    </div>
    <div class="col-md-9">
      <div class="mb-2"><label>Nombres</label><input name="nombre" class="form-control" value="<?=htmlspecialchars($user['nombre'] ?? '')?>" required></div>
      <div class="mb-2"><label>Email</label><input name="email" type="email" class="form-control" value="<?=htmlspecialchars($user['email'] ?? '')?>" required></div>
      <div class="mb-2"><label>Celular</label><input name="celular" class="form-control" value="<?=htmlspecialchars($user['celular'] ?? '')?>"></div>
      <button class="btn btn-primary">Guardar</button>
    </div>
  </div>
</form>