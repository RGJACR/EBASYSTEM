<h2>Panel Administrador</h2>
<div class="row">
  <div class="col-md-4 col-sm-6"><div class="card"><div class="card-body"><h6>Total II.EE</h6><h3><?= $totalInst ?></h3></div></div></div>
  <div class="col-md-4 col-sm-6"><div class="card"><div class="card-body"><h6>Total Usuarios</h6><h3><?= $totalUsers ?></h3></div></div></div>
  <div class="col-md-4 col-sm-12"><div class="card"><div class="card-body"><h6>Total Documentos</h6><h3><?= $totalDocs ?></h3></div></div></div>
</div>

<div class="row mt-3">
  <div class="col-md-6"><div class="card"><div class="card-header">Estudiantes por II.EE</div><div class="card-body"><div id="studentsApex" style="height:320px;"></div></div></div></div>
  <div class="col-md-6"><div class="card"><div class="card-header">Condición económica (total)</div><div class="card-body"><canvas id="condPie" style="max-height:300px"></canvas></div></div></div>
</div>

<div class="card mt-3"><div class="card-header">Condición económica por II.EE</div><div class="card-body">
<table class="table dt-export" id="condTable"><thead><tr><th>II.EE</th><th>Alta</th><th>Normal</th><th>Pobre</th><th>Muy pobre</th><th>Total encuestas</th></tr></thead><tbody><?php foreach($condByInst as $c): ?><tr><td><?=htmlspecialchars($c['nombre'])?></td><td><?=intval($c['alta'])?></td><td><?=intval($c['normal'])?></td><td><?=intval($c['pobre'])?></td><td><?=intval($c['muy_pobre'])?></td><td><?=intval($c['total_encuestas'])?></td></tr><?php endforeach; ?></tbody></table></div></div>

<div class="card mt-3"><div class="card-header">Usuarios (detallado)</div><div class="card-body"><table class="table dt-export" id="usersTable"><thead><tr><th>ID</th><th>Nombre</th><th>Email</th><th>Rol</th><th>II.EE</th></tr></thead><tbody><?php foreach($users as $u): ?><tr><td><?= $u['id'] ?></td><td><?=htmlspecialchars($u['nombre'])?></td><td><?=htmlspecialchars($u['email'])?></td><td><?=htmlspecialchars($u['rol'])?></td><td><?=htmlspecialchars($u['institucion'] ?? '-')?></td></tr><?php endforeach; ?></tbody></table></div></div>

<script>
document.addEventListener('DOMContentLoaded', function(){
  var labels = <?= json_encode(array_map(function($r){ return $r['institucion']; }, $studentsByInst ?? [])); ?>;
  var data = <?= json_encode(array_map(function($r){ return intval($r['total_students'] ?? 0); }, $studentsByInst ?? [])); ?>;
  try{
    var options = {
      chart: { type: 'bar', height: 320, toolbar: { show: false } },
      series: [{ name: 'Estudiantes', data: data }],
      xaxis: { categories: labels },
      plotOptions: { bar: { borderRadius: 8 } }
    };
    var chart = new ApexCharts(document.querySelector('#studentsApex'), options); chart.render();
  }catch(e){ console.error(e); }
  const pieData = <?= json_encode([intval($totals['alta'] ?? 0), intval($totals['normal'] ?? 0), intval($totals['pobre'] ?? 0), intval($totals['muy_pobre'] ?? 0)]); ?>;
  const pieCtx = document.getElementById('condPie')?.getContext('2d');
  if(pieCtx){
    new Chart(pieCtx, { type:'pie', data: { labels: ['Alta','Normal','Pobre','Muy pobre'], datasets:[{ data: pieData }] }, options:{ responsive:true, plugins:{ legend:{position:'bottom'} } } });
  }
});
</script>