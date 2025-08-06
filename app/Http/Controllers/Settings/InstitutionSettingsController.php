<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Services\SettingsService;
use Illuminate\Http\Request;

class InstitutionSettingsController extends Controller
{
    protected $settingsService;

    public function __construct(SettingsService $settingsService)
    {
        $this->settingsService = $settingsService;
    }

    public function index()
    {
        return view('settings.institution.index', [
            'settingsService' => $this->settingsService,
        ]);
    }

    public function update(Request $request)
    {
        $this->settingsService->update($request->except('_token'));

        return redirect()->route('settings.institution.index')->with('success', 'Configuración guardada con éxito.');
    }
}
