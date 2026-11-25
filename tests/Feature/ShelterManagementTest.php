<?php

namespace Tests\Feature;

use App\Models\Officer;
use App\Models\Schedule;
use App\Models\Shelter;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShelterManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_home_page_is_accessible_and_shows_database_data(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Shelter Management System', false);
        $response->assertSee('Statistik Shelter &amp; Penugasan', false);
    }

    public function test_admin_can_login_with_correct_credentials(): void
    {
        $response = $this->post('/login', [
            'login' => 'admin@shelter.com',
            'password' => 'TamanSafari2026',
        ]);

        $response->assertRedirect('/admin/dashboard');
        $this->assertAuthenticated();
    }

    public function test_admin_cannot_login_with_wrong_password(): void
    {
        $response = $this->post('/login', [
            'login' => 'admin@shelter.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors('login');
        $this->assertGuest();
    }

    public function test_guest_cannot_access_admin_dashboard(): void
    {
        $response = $this->get('/admin/dashboard');

        $response->assertRedirect('/login');
    }

    public function test_admin_can_logout(): void
    {
        $user = User::first();

        $response = $this->actingAs($user)->post('/logout');

        $response->assertRedirect('/login');
        $this->assertGuest();
    }

    public function test_shelter_crud_operations(): void
    {
        $user = User::first();

        // 1. Create
        $response = $this->actingAs($user)->post('/admin/shelters', [
            'name' => 'Shelter Uji Coba Baru',
            'code' => 'SH-99',
            'zone' => 'Zona Utara',
            'address' => 'Jl. Konservasi No. 99',
            'coordinator_name' => 'Letkol Budi Tester',
            'coordinator_phone' => '0812-9999-0000',
            'capacity' => 300,
            'current_occupancy' => 50,
            'guard_quota' => 6,
            'risk_level' => 'sedang',
            'status' => 'siaga_penuh',
            'description' => 'Posko uji coba pengujian sistem.',
        ]);

        $response->assertRedirect('/admin/shelters');
        $this->assertDatabaseHas('shelters', ['code' => 'SH-99']);

        $shelter = Shelter::where('code', 'SH-99')->first();

        // 2. Read
        $showResponse = $this->actingAs($user)->get("/admin/shelters/{$shelter->id}");
        $showResponse->assertStatus(200);
        $showResponse->assertSee('Shelter Uji Coba Baru');

        // 3. Update
        $updateResponse = $this->actingAs($user)->put("/admin/shelters/{$shelter->id}", [
            'name' => 'Shelter Uji Coba Terupdate',
            'code' => 'SH-99',
            'zone' => 'Zona Selatan',
            'address' => 'Jl. Konservasi No. 99 Baru',
            'coordinator_name' => 'Letkol Budi Tester Updated',
            'capacity' => 350,
            'guard_quota' => 8,
            'risk_level' => 'tinggi',
            'status' => 'siaga_penuh',
        ]);

        $updateResponse->assertRedirect('/admin/shelters');
        $this->assertDatabaseHas('shelters', ['name' => 'Shelter Uji Coba Terupdate']);

        // 4. Delete
        $deleteResponse = $this->actingAs($user)->delete("/admin/shelters/{$shelter->id}");
        $deleteResponse->assertRedirect('/admin/shelters');
        $this->assertDatabaseMissing('shelters', ['id' => $shelter->id]);
    }

    public function test_officer_crud_operations(): void
    {
        $user = User::first();
        $shelter = Shelter::first();

        // 1. Create
        $response = $this->actingAs($user)->post('/admin/officers', [
            'nrp' => '99887766',
            'name' => 'Petugas Satgas Test',
            'phone' => '0812-7777-8888',
            'email' => 'satgas.test@shelter.id',
            'address' => 'Asrama Posko',
            'position' => 'Ranger Sektor',
            'shelter_id' => $shelter->id,
            'status' => 'Aktif',
        ]);

        $response->assertRedirect('/admin/officers');
        $this->assertDatabaseHas('officers', ['nrp' => '99887766']);

        $officer = Officer::where('nrp', '99887766')->first();

        // 2. Read
        $showResponse = $this->actingAs($user)->get("/admin/officers/{$officer->id}");
        $showResponse->assertStatus(200);
        $showResponse->assertSee('Petugas Satgas Test');

        // 3. Update
        $updateResponse = $this->actingAs($user)->put("/admin/officers/{$officer->id}", [
            'nrp' => '99887766',
            'name' => 'Petugas Satgas Test Updated',
            'phone' => '0812-7777-9999',
            'position' => 'Komandan Regu',
            'shelter_id' => $shelter->id,
            'status' => 'Siaga',
        ]);

        $updateResponse->assertRedirect('/admin/officers');
        $this->assertDatabaseHas('officers', ['name' => 'Petugas Satgas Test Updated', 'status' => 'Siaga']);

        // 4. Delete
        $deleteResponse = $this->actingAs($user)->delete("/admin/officers/{$officer->id}");
        $deleteResponse->assertRedirect('/admin/officers');
        $this->assertDatabaseMissing('officers', ['id' => $officer->id]);
    }

    public function test_schedule_plotting_crud_and_conflict_detection(): void
    {
        $user = User::first();
        $shelter1 = Shelter::first();
        $shelter2 = Shelter::skip(1)->first();
        $officer = Officer::first();

        $targetDate = now()->addDays(10)->format('Y-m-d');

        // 1. Create Initial Schedule
        $createResponse = $this->actingAs($user)->post('/admin/schedules', [
            'shelter_id' => $shelter1->id,
            'officer_id' => $officer->id,
            'date' => $targetDate,
            'shift' => 'Pagi',
            'start_time' => '07:00',
            'end_time' => '15:00',
            'status' => 'Terjadwal',
            'notes' => 'Tugas shift pertama',
        ]);

        $createResponse->assertRedirect('/admin/schedules');
        $this->assertDatabaseHas('schedules', [
            'officer_id' => $officer->id,
            'shift' => 'Pagi',
            'notes' => 'Tugas shift pertama',
        ]);

        // 2. CRITICAL CONFLICT TEST: Attempt to plot SAME officer on SAME date and SAME shift at DIFFERENT shelter!
        $conflictResponse = $this->actingAs($user)->from('/admin/schedules/create')->post('/admin/schedules', [
            'shelter_id' => $shelter2->id,
            'officer_id' => $officer->id,
            'date' => $targetDate,
            'shift' => 'Pagi',
            'start_time' => '07:00',
            'end_time' => '15:00',
            'status' => 'Terjadwal',
            'notes' => 'Tugas bentrok harus ditolak',
        ]);

        // Must fail validation with conflict error
        $conflictResponse->assertSessionHasErrors('officer_id');

        // Verify only 1 schedule exists for this officer on that date
        $this->assertEquals(1, Schedule::where('officer_id', $officer->id)->whereDate('date', $targetDate)->count());

        // 3. AJAX Conflict API Check
        $ajaxResponse = $this->actingAs($user)->postJson('/admin/schedules/check-conflict', [
            'officer_id' => $officer->id,
            'date' => $targetDate,
            'shift' => 'Pagi',
        ]);

        $ajaxResponse->assertStatus(200);
        $ajaxResponse->assertJson([
            'valid' => false,
            'has_conflict' => true,
        ]);

        // 4. Update Schedule
        $schedule = Schedule::where('officer_id', $officer->id)->whereDate('date', $targetDate)->first();
        $updateResponse = $this->actingAs($user)->put("/admin/schedules/{$schedule->id}", [
            'shelter_id' => $shelter1->id,
            'officer_id' => $officer->id,
            'date' => $targetDate,
            'shift' => 'Siang',
            'start_time' => '15:00',
            'end_time' => '23:00',
            'status' => 'Siaga Shift',
            'notes' => 'Diubah ke shift siang',
        ]);

        $updateResponse->assertRedirect('/admin/schedules');
        $this->assertDatabaseHas('schedules', [
            'id' => $schedule->id,
            'shift' => 'Siang',
        ]);

        // 5. Delete Schedule
        $deleteResponse = $this->actingAs($user)->delete("/admin/schedules/{$schedule->id}");
        $deleteResponse->assertRedirect('/admin/schedules');
        $this->assertDatabaseMissing('schedules', ['id' => $schedule->id]);
    }

    public function test_calendar_page_is_accessible(): void
    {
        $user = User::first();

        $response = $this->actingAs($user)->get('/admin/calendar?view=month');
        $response->assertStatus(200);
        $response->assertSee('Kalender Penjagaan & Plotting');

        $weekResponse = $this->actingAs($user)->get('/admin/calendar?view=week');
        $weekResponse->assertStatus(200);

        $dayResponse = $this->actingAs($user)->get('/admin/calendar?view=day');
        $dayResponse->assertStatus(200);
    }

    public function test_reports_and_excel_export(): void
    {
        $user = User::first();

        $response = $this->actingAs($user)->get('/admin/reports?type=schedule');
        $response->assertStatus(200);
        $response->assertSee('Pusat Laporan & Rekapitulasi');

        $printResponse = $this->actingAs($user)->get('/admin/reports/print?type=schedule');
        $printResponse->assertStatus(200);
        $printResponse->assertSee('LAPORAN REKAPITULASI');

        $excelResponse = $this->actingAs($user)->get('/admin/reports/export-excel?type=schedule');
        $excelResponse->assertStatus(200);
        $excelResponse->assertHeader('Content-Type', 'application/vnd.ms-excel; charset=UTF-8');
    }

    public function test_settings_page_and_updates(): void
    {
        $user = User::first();

        $response = $this->actingAs($user)->get('/admin/settings');
        $response->assertStatus(200);
        $response->assertSee('Pengaturan Sistem & Akun');

        $updateProfile = $this->actingAs($user)->put('/admin/settings/profile', [
            'name' => 'Budi Santoso Updated',
            'email' => 'admin.updated@shelter.id',
            'phone' => '0812-0000-1111',
        ]);
        $updateProfile->assertRedirect();
        $this->assertDatabaseHas('users', ['email' => 'admin.updated@shelter.id']);
    }

    public function test_dashboard_renders_with_operational_metrics_and_quick_status_update(): void
    {
        $user = User::first();
        $schedule = Schedule::first();

        $response = $this->actingAs($user)->get('/admin/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Pusat Komando Operasional');
        $response->assertSee('Simulasi &amp; Uji Bentrok Plotting', false);

        $statusUpdate = $this->actingAs($user)->patchJson("/admin/schedules/{$schedule->id}/status", [
            'status' => 'Selesai Shift',
        ]);

        $statusUpdate->assertStatus(200);
        $statusUpdate->assertJson([
            'success' => true,
            'new_status' => 'Selesai Shift',
        ]);
        $this->assertDatabaseHas('schedules', [
            'id' => $schedule->id,
            'status' => 'Selesai Shift',
        ]);
    }
}
