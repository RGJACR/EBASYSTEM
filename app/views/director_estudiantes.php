<h3>Estudiantes</h3>
<form method="post" enctype="multipart/form-data" action="index.php?c=Director&a=estudiantes">
  <div class="mb-2"><label>Subir CSV</label><input type="file" name="csv" accept=".csv"></div>
  <button class="btn btn-primary btn-sm">Cargar masivo</button>
  <a class="btn btn-link" href="index.php?c=Director&a=descargar_plantilla">Descargar plantilla</a>
</form>
<hr>
<button class="btn btn-success mb-2" onclick="document.getElementById('formAdd').style.display='block'">Agregar</button>
<div id="formAdd" style="display:none" class="card card-body mt-2">
  <form method="post" action="index.php?c=Director&a=agregar_estudiante">
    <input name="nombre" class="form-control mb-1" placeholder="Nombre" required>
    <select name="grado" class="form-control mb-1">
      <option>1er Grado</option><option>2do Grado</option><option>3er Grado</option><option>4to Grado</option>
    </select>
    <input name="edad" class="form-control mb-1" placeholder="Edad">
    <input name="celular" class="form-control mb-1" placeholder="Celular">
    <button class="btn btn-primary btn-sm">Crear</button>
  </form>
</div>
<table class="table dt-export" id="est"><thead><tr><th>ID</th><th>Nombre</th><th>Grado</th><th>Edad</th><th>Celular</th><th>Acciones</th></tr></thead><tbody><?php foreach($estudiantes as $e): ?><tr><td><?=$e['id']?></td><td><?=htmlspecialchars($e['nombre'])?></td><td><?=htmlspecialchars($e['grado'])?></td><td><?=$e['edad']?></td><td><?=htmlspecialchars($e['celular'])?></td><td><button class="btn btn-sm btn-warning editStudentBtn" data-id="<?=$e['id']?>" data-nombre="<?=htmlspecialchars($e['nombre'])?>" data-grado="<?=htmlspecialchars($e['grado'])?>" data-edad="<?=$e['edad']?>" data-cel="<?=htmlspecialchars($e['celular'])?>">Editar</button></td></tr><?php endforeach; ?></tbody></table>

<!-- Edit Student Modal -->
<div class="modal fade" id="editStudentModal" tabindex="-1" role="dialog"><div class="modal-dialog modal-md" role="document"><div class="modal-content">
<form method="post" action="index.php?c=Director&a=editar_estudiante">
<div class="modal-header"><h5 class="modal-title">Editar Estudiante</h5><button class="close" data-dismiss="modal">&times;</button></div>
<div class="modal-body">
  <input type="hidden" name="id" id="stu_id">
  <div class="form-group"><label>Nombre</label><input name="nombre" id="stu_nombre" class="form-control" required></div>
  <div class="form-group"><label>Grado</label><select name="grado" id="stu_grado" class="form-control"><option>1er Grado</option><option>2do Grado</option><option>3er Grado</option><option>4to Grado</option></select></div>
  <div class="form-group"><label>Edad</label><input name="edad" id="stu_edad" class="form-control" type="number"></div>
  <div class="form-group"><label>Celular</label><input name="celular" id="stu_cel" class="form-control"></div>
</div>
<div class="modal-footer"><button class="btn btn-secondary" data-dismiss="modal">Cancelar</button><button class="btn btn-success">Guardar</button></div>
</form></div></div></div>