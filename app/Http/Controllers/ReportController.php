<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;


class ReportController extends Controller
    {
    /**
    * REPORTE 1: Clientes por zona geográfica
    */
    public function clientesPorZona()
    {
    // 1. Consulta con Query Builder
    $zonas = DB::table('clients')->select(
    'zona_geografica',
    DB::raw('COUNT(*) as total')
    )->groupBy('zona_geografica')->orderByDesc('total')->get();
    // 2. Total general
    $totalGeneral = $zonas->sum('total');
    // 3. Agregar porcentaje
    $zonasConPorcentaje = $zonas->map(function ($zona) use ($totalGeneral) {
    $zona->porcentaje = $totalGeneral > 0
    ? round(($zona->total / $totalGeneral) * 100, 2)
    : 0;
    return $zona;
    });
    = 
    // 4. Datos para el gráfico
    $labels = $zonasConPorcentaje->pluck('zona_geografica')->toArray();
    $data
    $zonasConPorcentaje->pluck('total')->toArray();
    return view('reports.zonas', compact(
    'zonasConPorcentaje', 'totalGeneral', 'labels', 'data'
    ));
    }
}