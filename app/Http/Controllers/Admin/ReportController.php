<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $metrics = [];        // Aquí cargarías métricas reales
        $recentReports = [];  // Aquí obtendrías reportes recientes

        return view('admin.reportes.index', compact('metrics', 'recentReports'));
    }

    public function create()
    {
        return view('admin.reportes.create');
    }

    public function store(Request $request)
    {
        // Guarda un nuevo reporte
    }

    public function show($report)
    {
        // Muestra un reporte en detalle
    }

    public function archive()
    {
        // Listado/historial de reportes
        return view('admin.reportes.archive');
    }
}
