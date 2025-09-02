<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Services\SettingsService;
use App\Models\AcademicYear;
use Illuminate\Http\Request;

class InstitutionSettingsController extends Controller
{
    protected $settingsService;

    public function __construct(SettingsService $settingsService)
    {
        $this->settingsService = $settingsService;
    }

    public function index(Request $request)
    {
        // Determina la pestaña activa desde la URL, por defecto 'institution'
        $activeTab = $request->query('tab', 'institution');

        // Carga los datos necesarios para cada pestaña
        $academicYears = AcademicYear::orderBy('start_date', 'desc')->get();

        return view('settings.index', [
            'settingsService' => $this->settingsService,
            'academicYears' => $academicYears,
            'activeTab' => $activeTab,
        ]);
    }

    public function update(Request $request)
    {
        // Usamos $request->except para excluir también el campo _method que se envía en formularios PUT/PATCH
        $this->settingsService->update($request->except('_token', '_method'));

        // Redirige de vuelta a la misma pestaña de institución
        return redirect()->route('settings.index', ['tab' => 'institution'])->with('success', 'Configuración de la institución guardada con éxito.');
    }
}