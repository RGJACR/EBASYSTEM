<h3>Plana Docente</h3>
<div class="mb-2"><a class="btn btn-sm btn-info" href="index.php?c=Director&a=evaluaciones">Ver Evaluaciones</a></div>
<form method="post" action="index.php?c=Director&a=crear_docente">
  <input name="nombre" class="form-control mb-1" placeholder="Nombre" required>
  <input name="email" class="form-control mb-1" placeholder="Email" required>
  <input name="password" class="form-control mb-1" placeholder="Contraseña" required>
  <input name="celular" class="form-control mb-1" placeholder="Celular">
  <button class="btn btn-primary btn-sm">Crear docente</button>
</form>
<hr>
<h5>Docentes</h5>
<table class="table dt-export" id="docsList"><thead><tr><th>ID</th><th>Nombre</th><th>Email</th><th>Celular</th><th>Estado</th><th>Acciones</th></tr></thead><tbody><?php foreach($docentes as $d): ?><tr><td><?=$d['id']?></td><td><?=htmlspecialchars($d['nombre'])?></td><td><?=htmlspecialchars($d['email'])?></td><td><?=htmlspecialchars($d['celular'] ?? '')?></td><td><?=htmlspecialchars($d['estado'] ?? 'activo')?></td><td><button class="btn btn-sm btn-warning editDocBtn" data-id="<?=$d['id']?>" data-nombre="<?=htmlspecialchars($d['nombre'])?>" data-email="<?=htmlspecialchars($d['email'])?>" data-cel="<?=htmlspecialchars($d['celular'] ?? '')?>">Editar</button> <a class="btn btn-sm btn-info" href="index.php?c=Director&a=toggle_docente_status&id=<?=$d['id']?>"><?=($d['estado'] ?? 'activo')==='activo'?'Dar de Baja':'Activar'?></a> <button class="btn btn-sm btn-primary evaluateDocBtn" data-id="<?=$d['id']?>" data-nombre="<?=htmlspecialchars($d['nombre'])?>">Evaluar</button></td></tr><?php endforeach; ?></tbody></table>

<!-- Edit Docente Modal -->
<div class="modal fade" id="editDocModal" tabindex="-1" role="dialog"><div class="modal-dialog modal-md" role="document"><div class="modal-content">
<form method="post" action="index.php?c=Director&a=editar_docente">
<div class="modal-header"><h5 class="modal-title">Editar Docente</h5><button class="close" data-dismiss="modal">&times;</button></div>
<div class="modal-body">
  <input type="hidden" name="id" id="doc_id">
  <div class="form-group"><label>Nombre</label><input name="nombre" id="doc_nombre" class="form-control" required></div>
  <div class="form-group"><label>Email</label><input name="email" id="doc_email" class="form-control" type="email" required></div>
  <div class="form-group"><label>Celular</label><input name="celular" id="doc_cel" class="form-control"></div>
</div>
<div class="modal-footer"><button class="btn btn-secondary" data-dismiss="modal">Cancelar</button><button class="btn btn-success">Guardar</button></div>
</form></div></div></div>