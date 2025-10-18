<h2>Evaluación de Directores (Admin)</h2>
<div class="mb-2"><button class="btn btn-primary" data-toggle="modal" data-target="#evalAdminModal">Nueva Evaluación</button></div>
<table class="table dt-export" id="adminEvalsTable"><thead><tr><th>ID</th><th>Director</th><th>II.EE</th><th>Calificación</th><th>Archivo</th><th>Fecha</th></tr></thead><tbody><?php foreach($evaluaciones as $ev): ?><tr><td><?=$ev['id']?></td><td><?=htmlspecialchars($ev['director'] ?? '-')?></td><td><?=htmlspecialchars($ev['institucion_id'])?></td><td><?=intval($ev['calificacion'])?></td><td><?php if($ev['archivo']): ?><a href="<?=htmlspecialchars($ev['archivo'])?>" target="_blank">Ver</a><?php endif; ?></td><td><?=htmlspecialchars($ev['creado_en'])?></td></tr><?php endforeach; ?></tbody></table>

<!-- Modal crear evaluación -->
<div class="modal fade" id="evalAdminModal" tabindex="-1" role="dialog"><div class="modal-dialog modal-md" role="document"><div class="modal-content">
<form method="post" action="index.php?c=Admin&a=evaluaciones" enctype="multipart/form-data">
<div class="modal-header"><h5 class="modal-title">Evaluación Director</h5><button class="close" data-dismiss="modal">&times;</button></div>
<div class="modal-body">
  <input type="hidden" name="action" value="evaluate">
  <div class="form-group"><label>Director</label><select name="director_id" class="form-control"><?php foreach($directores as $d): ?><option value="<?=$d['id']?>"><?=htmlspecialchars($d['nombre'])?> (ID <?=$d['id']?>)</option><?php endforeach; ?></select></div>
  <div class="form-group"><label>II.EE</label><select name="institucion_id" class="form-control"><option value="">-- Seleccionar II.EE --</option><?php foreach($inst as $i): ?><option value="<?=$i['id']?>"><?=htmlspecialchars($i['nombre'])?></option><?php endforeach; ?></select></div>
  <div class="form-group"><label>Archivo</label><input type="file" name="archivo" class="form-control"></div>
  <div class="form-group"><label>Calificación</label><input type="number" name="calificacion" min="1" max="20" class="form-control" required></div>
</div>
<div class="modal-footer"><button class="btn btn-secondary" data-dismiss="modal">Cancelar</button><button class="btn btn-success">Guardar</button></div>
</form></div></div></div>