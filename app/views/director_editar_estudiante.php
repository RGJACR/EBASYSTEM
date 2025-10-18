<h3>Editar Estudiante (fallback)</h3>
<form method="post" action="index.php?c=Director&a=editar_estudiante">
  <input type="hidden" name="id" value="<?= $est['id'] ?? 0 ?>">
  <div class="mb-2"><label>Nombre</label><input name="nombre" class="form-control" value="<?=htmlspecialchars($est['nombre'] ?? '')?>" required></div>
  <div class="mb-2"><label>Grado</label><select name="grado" class="form-control"><option>1er Grado</option><option>2do Grado</option><option>3er Grado</option><option>4to Grado</option></select></div>
  <div class="mb-2"><label>Edad</label><input name="edad" class="form-control" value="<?=intval($est['edad'] ?? 0)?>"></div>
  <div class="mb-2"><label>Celular</label><input name="celular" class="form-control" value="<?=htmlspecialchars($est['celular'] ?? '')?>"></div>
  <button class="btn btn-primary">Guardar</button>
</form>