<h2>Usuarios (Administrar II.EE)</h2>
<div class="card card-body">
  <h5>Crear usuario</h5>
  <form method="post" action="index.php?c=Admin&a=users">
    <input type="hidden" name="action" value="create">
    <div class="form-row">
      <div class="col"><input name="nombre" class="form-control" placeholder="Nombre" required></div>
      <div class="col"><input name="email" class="form-control" placeholder="Email" required></div>
      <div class="col"><input name="password" class="form-control" placeholder="Contraseña (opcional)"></div>
      <div class="col"><select name="rol" class="form-control"><option>ADMINISTRADOR</option><option>DIRECTOR</option><option>DOCENTE</option></select></div>
      <div class="col"><select name="institucion_id" class="form-control"><option value="">--II.EE (opcional)--</option><?php foreach($inst as $i): ?><option value="<?=$i['id']?>"><?=htmlspecialchars($i['nombre'])?></option><?php endforeach; ?></select></div>
      <div class="col"><button class="btn btn-success">Crear</button></div>
    </div>
  </form>
</div>

<hr>
<h5>Listado de usuarios</h5>
<table class="table dt-export" id="adminUsersTable"><thead><tr><th>ID</th><th>Nombre</th><th>Email</th><th>Rol</th><th>II.EE</th><th>Acciones</th></tr></thead><tbody><?php foreach($users as $u): ?><tr><td><?=$u['id']?></td><td><?=htmlspecialchars($u['nombre'])?></td><td><?=htmlspecialchars($u['email'])?></td><td><?=htmlspecialchars($u['rol'])?></td><td><?=htmlspecialchars($u['institucion'] ?? '-')?></td><td><button class="btn btn-sm btn-warning editAdminUserBtn" data-id="<?=$u['id']?>" data-nombre="<?=htmlspecialchars($u['nombre'])?>" data-email="<?=htmlspecialchars($u['email'])?>" data-rol="<?=htmlspecialchars($u['rol'])?>" data-inst="<?=htmlspecialchars($u['institucion_id'] ?? '')?>">Editar</button></td></tr><?php endforeach; ?></tbody></table>

<!-- Edit modal -->
<div class="modal fade" id="editAdminUserModal" tabindex="-1" role="dialog"><div class="modal-dialog modal-md" role="document"><div class="modal-content">
<form method="post" action="index.php?c=Admin&a=editar_usuario">
<div class="modal-header"><h5 class="modal-title">Editar Usuario</h5><button class="close" data-dismiss="modal">&times;</button></div>
<div class="modal-body">
  <input type="hidden" name="id" id="adm_id">
  <div class="form-group"><label>Nombre</label><input name="nombre" id="adm_nombre" class="form-control" required></div>
  <div class="form-group"><label>Email</label><input name="email" id="adm_email" class="form-control" required></div>
  <div class="form-group"><label>Celular</label><input name="celular" id="adm_cel" class="form-control"></div>
  <div class="form-group"><label>Rol</label><select name="rol" id="adm_rol" class="form-control"><option>ADMINISTRADOR</option><option>DIRECTOR</option><option>DOCENTE</option></select></div>
  <div class="form-group"><label>II.EE</label><select name="institucion_id" id="adm_inst" class="form-control"><option value="">-- Ninguna --</option><?php foreach($inst as $i): ?><option value="<?=$i['id']?>"><?=htmlspecialchars($i['nombre'])?></option><?php endforeach; ?></select></div>
</div>
<div class="modal-footer"><button class="btn btn-secondary" data-dismiss="modal">Cancelar</button><button class="btn btn-success">Guardar</button></div>
</form></div></div></div>