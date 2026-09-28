<?php

namespace Tests\Feature;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PenggunaTest extends TestCase
{
    public function test_guest_ditolak(): void
    {
        $response = $this->get('/pengguna');
        $response->assertRedirect('/login');
    }

    public function test_admin_bisa_lihat_daftar(): void
    {
        $admin = Admin::first();
        $response = $this->actingAs($admin)->get('/pengguna');
        $response->assertStatus(200);
        $response->assertSee('Manajemen Pengguna');
        $response->assertSee('Tambah Pengguna');
        $response->assertSee($admin->email);
    }

    public function test_admin_bisa_tambah(): void
    {
        $admin = Admin::first();
        $response = $this->actingAs($admin)->post('/pengguna', [
            'name' => 'Admin Baru',
            'email' => 'adminbaru_'.time().'@mail.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
            'tanggal_lahir' => '2000-05-05',
        ]);
        $response->assertRedirect(route('pengguna.index'));
        $this->assertDatabaseHas('admin', ['name' => 'Admin Baru']);
        Admin::where('name', 'Admin Baru')->delete();
    }

    public function test_tidak_bisa_hapus_diri_sendiri(): void
    {
        $admin = Admin::first();
        $response = $this->actingAs($admin)->delete('/pengguna/'.$admin->id);
        $response->assertRedirect(route('pengguna.index'));
        $this->assertDatabaseHas('admin', ['id' => $admin->id]);
    }

    public function test_pasien_index_fokus_pasien(): void
    {
        $admin = Admin::first();
        $response = $this->actingAs($admin)->get('/pasien');
        $response->assertStatus(200);
        $response->assertSee('Manajemen Pasien');
        $response->assertSee('Tambah Pasien');
        $response->assertDontSee('Total Pengguna');
        $response->assertDontSee('Total Semua Pengguna');
    }

    public function test_pengguna_index_fokus_pengguna(): void
    {
        $admin = Admin::first();
        $response = $this->actingAs($admin)->get('/pengguna');
        $response->assertStatus(200);
        $response->assertSee('Manajemen Pengguna');
        $response->assertSee('Tambah Pengguna');
        $response->assertDontSee('Total Pasien');
        $response->assertDontSee('Total Semua Pengguna');
    }
}
