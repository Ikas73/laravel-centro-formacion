<?php

namespace Tests\Feature\Settings;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class InstitutionSettingsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Seed the database with roles and permissions
        $this->artisan('db:seed');
    }

    public function test_unauthenticated_user_cannot_access_institution_settings()
    {
        $response = $this->get(route('settings.institution.index'));
        $response->assertRedirect('/login');
    }

    public function test_unauthorized_user_cannot_access_institution_settings()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('settings.institution.index'));
        $response->assertForbidden();
    }

    public function test_admin_can_access_institution_settings()
    {
        $admin = User::where('email', 'admin@admin.com')->first();
        $response = $this->actingAs($admin)->get(route('settings.institution.index'));
        $response->assertStatus(200);
    }

    public function test_admin_can_update_institution_settings()
    {
        $admin = User::where('email', 'admin@admin.com')->first();
        $this->actingAs($admin);

        $controller = new \App\Http\Controllers\Settings\InstitutionSettingsController(new \App\Services\SettingsService());

        $request = \Illuminate\Http\Request::create(route('settings.institution.update'), 'POST', [
            'school_name' => 'East Bridge High School',
            'school_address' => '123 Main St',
        ]);

        $response = $controller->update($request);

        $this->assertDatabaseHas('settings', [
            'key' => 'school_name',
            'value' => 'East Bridge High School'
        ]);
        $this->assertDatabaseHas('settings', [
            'key' => 'school_address',
            'value' => '123 Main St'
        ]);

        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $response);
        $this->assertEquals(route('settings.institution.index'), $response->getTargetUrl());
    }
}
