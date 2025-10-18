<h3>Gestión Pedagógica</h3>
<?php if(!empty($error)): ?><div class="alert alert-danger"><?=htmlspecialchars($error)?></div><?php endif; ?>
<form method="post" action="index.php?c=Docente&a=pedagogica" enctype="multipart/form-data">
  <div class="mb-2"><label>Tipo</label><select name="tipo" class="form-control"><option>PROGRAMACIÓN ANUAL DE TRABAJO</option><option>UNIDAD DE APRENDIZAJE</option><option>SESION DE APRENDIZAJE</option><option>PROYECTOS DE APRENDIZAJE</option></select></div>
  <div class="mb-2"><label>Archivo</label><input type="file" name="archivo" class="form-control" required></div>
  <button class="btn btn-success">Subir</button>
</form>
<p class="text-muted small mt-2">Se permiten: pdf, doc, docx, txt, xls, xlsx, csv.</p>