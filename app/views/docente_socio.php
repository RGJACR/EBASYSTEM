<h3>Gestión Socio Económica</h3>
<p>Listado de estudiantes para encuestas</p>
<table class="table dt-export" id="estList">
  <thead>
    <tr>
      <th>ID</th>
      <th>Nombre</th>
      <th>Grado</th>
      <th>Acción</th>
      </tr>
  </thead>

<tbody><?php foreach (
    $estudiantes
    as $e
): ?><tr><td><?= $e["id"] ?></td><td><?= htmlspecialchars(
    $e["nombre"]
) ?></td><td><?= htmlspecialchars(
    $e["grado"]
) ?></td><td><button class="btn btn-sm btn-primary encuestarBtn" data-id="<?= $e[
    "id"
] ?>" data-nombre="<?= htmlspecialchars(
    $e["nombre"]
) ?>" data-grado="<?= htmlspecialchars(
    $e["grado"]
) ?>" data-cel="<?= htmlspecialchars(
    $e["celular"]
) ?>" data-edad="<?= htmlspecialchars(
    $e["edad"]
) ?>">Encuestar</button></td></tr><?php endforeach; ?></tbody></table>

<!-- Encuesta Modal -->
<div class="modal fade" id="encModal" tabindex="-1" role="dialog"><div class="modal-dialog modal-md" role="document"><div class="modal-content">
<form method="post" action="index.php?c=Docente&a=encuesta">
<div class="modal-header"><h5 class="modal-title">Encuesta</h5><button class="close" data-dismiss="modal">&times;</button></div>
  <div class="modal-body">
    
    <input type="hidden" name="estudiante_id" id="enc_est_id">
    <div class="form-group">
      <label>Nombre</label>
      <input type="text" id="enc_est_name" class="form-control" disabled></div>
    <div class="form-group">
      <label>Grado</label>
      <select name="respuesta[grado]" id="enc_est_grado" class="form-control">
        <option>1er Grado</option>
        <option>2do Grado</option>
        <option>3er Grado</option>
        <option>4to Grado</option>
      </select></div>
    
    <div class="form-group"><label>Condición económica</label>
      <select name="respuesta[condicion]" class="form-control">
        <option>alta</option>
        <option>normal</option>
        <option>pobre</option>
        <option>muy pobre</option>
      </select>
    </div>

    <div class="form-group">
      <label>Edad</label>
      <input name="respuesta[edad]" id="enc_est_edad" class="form-control" type="number">
    </div>

    <div class="form-group">
      <label>Celular</label>
      <input name="respuesta[celular]" id="enc_est_cel" class="form-control">
    </div>

  </div>

<div class="modal-footer"><button class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
  <button class="btn btn-primary">Guardar encuesta</button>
</div>

</form></div></div></div>