<h3>Gestión Estratégica - Colocar notas</h3>
<form method="post" action="index.php?c=Docente&a=guardar_nota" class="mb-3">
    <div class="form-row">
        <div class="col">
            <select name="estudiante_id" class="form-control"><?php foreach (
                $estudiantes
                as $e
            ): ?>
            <option value="<?= $e["id"] ?>"><?= htmlspecialchars(
                $e["nombre"]
                ) ?> (<?= $e["grado"] ?>)
            </option>
        <?php endforeach; ?>
            </select>
        </div>
        
        <div class="col">
            <select name="area" class="form-control">
                <option>Comunicación Integral</option>
                <option>Inglés</option>
                <option>Ciencias Sociales</option>
                <option>Arte y Cultura</option>
                <option>Matemática</option>
                <option>Ciencia, Tecnología y Ambiente</option>
                <option>Desarrollo Personal, Ciudadanía y Cívica</option>
                <option>Educación Religiosa</option>
                <option>Educación Física</option>
            </select>
        </div>
        <div class="col"><input name="nota" class="form-control" placeholder="Nota" required></div>
        <div class="col"><button class="btn btn-success">Guardar nota</button></div>
    </div>
</form>

<hr>
<h4>Notas guardadas</h4>
<table class="table dt-export" id="notasTable">
    <thead>
        <tr>
            <th>ID</th>
            <th>Estudiante</th>
            <th>Grado</th>
            <th>Area</th>
            <th>Nota</th>
            <th>Fecha</th>
            <th>Acción</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach (
    $notas
    as $n
): ?>
        <tr>
            <td>
                <?= $n["id"] ?>
            </td>
            <td>
                <?= htmlspecialchars(
    $n["estudiante"] ?? "-"
) ?>
            </td>
            <td>
                <?= htmlspecialchars($n["grado"]) ?>
            </td>
            <td>
                <?= htmlspecialchars(
    $n["area"]
) ?>
            </td>
            <td>
                <?= htmlspecialchars($n["nota"]) ?>
            </td>
            <td>
                <?= htmlspecialchars(
    $n["creado_en"]
) ?>
            </td>
            <td><button class="btn btn-sm btn-warning editNotaBtn" data-id="<?= $n[
    "id"
] ?>" data-area="<?= htmlspecialchars(
    $n["area"] ?? " "
) ?>" data-nota="<?= htmlspecialchars(
    $n["nota"] ?? " "
) ?>" data-estudiante="<?= htmlspecialchars(
    $n["estudiante"] ?? "- "
) ?>" data-grado="<?= htmlspecialchars(
    $n["grado"] ?? " "
) ?>">Editar</button></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Edit Nota Modal -->
<div class="modal fade" id="notaModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <form method="post" action="index.php?c=Docente&a=editar_nota">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Nota</h5><button class="close" data-dismiss="modal">&times;</button></div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="nota_id">
                    <div class="form-group"><label>Estudiante</label><input id="nota_estudiante" class="form-control" disabled></div>
                    <div class="form-group"><label>Area</label><input name="area" id="nota_area" class="form-control" required></div>
                    <div class="form-group"><label>Nota</label><input name="nota" id="nota_val" class="form-control" required></div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button class="btn btn-success">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>