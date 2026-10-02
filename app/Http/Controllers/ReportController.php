<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function clientesPorZona()
    {
        // 1. Consulta con Query Builder
        $zonas = DB::table('clients') // ← HUECO A
            ->select(
                'zona_geografica', // ← HUECO B
                DB::raw('COUNT(*) as total') // ← HUECO C
            )
            ->groupBy('zona_geografica') // ← HUECO D
            ->orderByDesc('total') // ← HUECO E
            ->get(); // ← HUECO F
        // 2. Total general
        $totalGeneral = $zonas->sum('total'); // ← HUECO G
        // 3. Agregar porcentaje
        $zonasConPorcentaje = $zonas->map(function ($zona) use ($totalGeneral) {
            // ← HUECO H
            $zona->porcentaje = $totalGeneral > 0
                ? round(($zona->total / $totalGeneral) * 100, 2) // ← HUECO I
                : 0;
            return $zona; // ← HUECO J
        });
        //reto de modificacion para filtrar las zonas con porcentaje mayor a 15
        $zonasConPorcentaje = $zonasConPorcentaje->filter(function ($zona) {
            return $zona->porcentaje > 15;
        });
        // 4. Datos para gráfico
        $labels = $zonasConPorcentaje->pluck('zona_geografica')->values()->toArray(); // ← HUECO K
        $data = $zonasConPorcentaje->pluck('total')->values()->toArray(); // ← HUECO L
        return view('reports.zonas', compact(
            'zonasConPorcentaje',
            'totalGeneral',
            'labels',
            'data'
        ));
    }

    public function interaccionesPorAsesor()
    {
        $asesores = DB::table('users') // ← HUECO A
            ->select(
                'users.id',
                'users.name',
                DB::raw("COUNT(CASE WHEN interactions.tipo_interaccion = 'llamada'
THEN 1 END) AS llamadas"), // ← HUECO B
                DB::raw("COUNT(CASE WHEN interactions.tipo_interaccion = 'visita'
THEN 1 END) AS visitas"), // ← HUECO C
                DB::raw("COUNT(CASE WHEN interactions.tipo_interaccion = 'whatsapp'
THEN 1 END) AS whatsapp"), // ← HUECO D
                DB::raw('COUNT(interactions.id) AS total'), // ← HUECO E
                DB::raw('DAYNAME(interactions.fecha_seguimiento) as dia_semana'),
            )
            ->leftJoin('clients', 'clients.user_id', '=', 'users.id')
            ->leftJoin('interactions', 'interactions.client_id', '=', 'clients.id')
            ->groupBy(
                'users.id',
                'users.name',
                DB::raw('DAYNAME(interactions.fecha_seguimiento)')
            )
            ->orderByDesc('total')
            ->get();
        $labels = $asesores->pluck('name')->toArray(); // ← HUECO K
        $llamadas = $asesores->pluck('llamadas')->toArray(); // ← HUECO L
        $visitas = $asesores->pluck('visitas')->toArray(); // ← HUECO M
        $whatsapp = $asesores->pluck('whatsapp')->toArray(); // ← HUECO N
        return view('reports.interacciones', compact(
            'asesores',
            'labels',
            'llamadas',
            'visitas',
            'whatsapp'
        ));
    }
}
