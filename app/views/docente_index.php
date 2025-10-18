<h2>Panel Docente</h2>
<div class="mb-2">
	
<h5>Mis documentos</h5>
<table class="table dt-export" id="docs">
	<thead>
		<tr>
			<th>ID</th>
			<th>Módulo</th>
			<th>Tipo</th>
			<th>Archivo</th>
			<th>Estado</th>
		</tr>
	</thead>

	<tbody><?php foreach (
    $docs
    as $d
): ?><tr>
		<td><?= $d["id"] ?>
		</td>

		<td><?= htmlspecialchars(
    $d["modulo"]
) ?></td>
		<td><?= htmlspecialchars(
    $d["tipo"]
) ?></td>
		<td><a href="<?= htmlspecialchars(
    $d["ruta"]
) ?>" target="_blank"><?= htmlspecialchars(
    $d["nombre_original"]
) ?></a>
		</td>
		<td><?= htmlspecialchars(
    $d["estado"]
    ) ?></td>
	</tr><?php endforeach; ?>
	
	</tbody>
</table>