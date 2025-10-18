<h3>Editar Docente</h3>
<form method="post" action="index.php?c=Director&a=editar_docente">
  <input type="hidden" name="id" value="<?= $doc['id'] ?? 0 ?>">
  <div class="mb-2"><label>Nombre</label><input name="nombre" class="form-control" value="<?=htmlspecialchars($doc['nombre'] ?? '')?>" required></div>
  <div class="mb-2"><label>Email</label><input name="email" class="form-control" value="<?=htmlspecialchars($doc['email'] ?? '')?>" required></div>
  <div class="mb-2"><label>Celular</label><input name="celular" class="form-control" value="<?=htmlspecialchars($doc['celular'] ?? '')?>"></div>
  <button class="btn btn-primary">Guardar</button>
</form>