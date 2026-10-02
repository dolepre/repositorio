<!DOCTYPE html>
<html lang="es">
<head>
 <meta charset="UTF-8">
 <title>Interacciones por Asesor</title>
 <link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
 <h1 class="mb-4">📞 Interacciones por Asesor</h1>
 <div class="card mb-4">
 <div class="card-header bg-dark text-white"><h5 class="mb-0">Desglose por
Tipo</h5></div>
 <div class="card-body">
 <table class="table table-hover">
 <thead class="table-dark">
 <tr>
 <th>#</th><th>Asesor</th>
<th class="text-center">📞 Llamadas</th>
<th class="text-center">🏢 Visitas</th>
<th class="text-center">💬 WhatsApp</th>
<th class="text-center">TOTAL</th>
 </tr>
 </thead>
 <tbody>
 @foreach($asesores as $i => $a)
 <tr>
 <td>{{ $i + 1 }}</td>
<td><strong>{{ $a->name }}</strong></td>
<td class="text-center"><span class="badge bg-primary">
{{ $a->llamadas }}</span></td>
 <td class="text-center"><span class="badge bg-success">
{{ $a->visitas }}</span></td>
 <td class="text-center"><span class="badge bg-warning
text-dark">{{ $a->whatsapp }}</span></td>
 <td class="text-center"><span class="badge bg-danger fs6">{{ $a->total }}</span></td>
 </tr>
 @endforeach
 </tbody>
 </table>
 </div>
 </div>
 <div class="card">
 <div class="card-body"><canvas id="grafico" height="80"></canvas></div>
 </div>
 <div class="mt-3">
 <a href="{{ route('reportes.zonas') }}" class="btn btn-secondary">←
Anterior</a>
 </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js">
</script>
<script>

    const llamadas = @json($llamadas);
    const visitas = @json($visitas);
    const whatsapp = @json($whatsapp);
    const labels = @json($labels);
 new Chart(document.getElementById('grafico'), {
 type: 'bar',
 data: {
 labels: labels,
 datasets: [
 { label: 'Llamadas', data: llamadas, backgroundColor:
'#0d6efd' },
 { label: 'Visitas', data: visitas, backgroundColor:
'#198754' },
 { label: 'WhatsApp', data: whatsapp, backgroundColor:
'#ffc107' }
 ]
 },
 options: {
 responsive: true,
 scales: { x: { stacked: true }, y: { stacked: true, beginAtZero: true }
}
 }
 });
</script>
</body>
</html>
