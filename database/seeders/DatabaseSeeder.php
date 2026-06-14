<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::firstOrCreate(['name' => 'Master']);
        Role::firstOrCreate(['name' => 'Administrador']);
        Role::firstOrCreate(['name' => 'Cliente']);

        $admin = User::factory()->create([
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'password' => 'password',
            'must_change_password' => false,
        ]);
        $admin->assignRole('Master');

        $client = Client::factory()->create([
            'razao_social' => 'Cliente Modelo LTDA',
            'nome_fantasia' => 'Cliente Modelo',
            'cnpj' => '12.345.678/0001-99',
            'email' => 'cliente@example.com',
            'telefone' => '+5511999999999',
            'status' => 'ativo',
            'registered_at' => now(),
        ]);

        $user = User::factory()->create([
            'name' => 'Cliente Modelo',
            'email' => 'cliente@example.com',
            'password' => 'password',
            'client_id' => $client->id,
            'phone' => '+5511999999999',
        ]);
        $user->assignRole('Cliente');

        $client1111 = Client::factory()->create([
            'razao_social' => 'Teste CNPJ 1111 LTDA',
            'nome_fantasia' => 'Teste 1111',
            'cnpj' => '11.111.111/0001-11',
            'email' => 'teste1111@example.com',
            'telefone' => '+5511988888888',
            'status' => 'ativo',
            'registered_at' => now(),
        ]);

        $user1111 = User::factory()->create([
            'name' => 'Cliente 1111',
            'email' => 'cliente1111@example.com',
            'password' => 'password',
            'client_id' => $client1111->id,
            'phone' => '+5511988888888',
        ]);
        $user1111->assignRole('Cliente');

        $client2222 = Client::factory()->create([
            'razao_social' => 'Teste CNPJ 2222 LTDA',
            'nome_fantasia' => 'Teste 2222',
            'cnpj' => '22.222.222/0001-22',
            'email' => 'teste2222@example.com',
            'telefone' => '+5511977777777',
            'status' => 'ativo',
            'registered_at' => now(),
        ]);

        $user2222 = User::factory()->create([
            'name' => 'Cliente 2222',
            'email' => 'cliente2222@example.com',
            'password' => 'password',
            'client_id' => $client2222->id,
            'phone' => '+5511977777777',
        ]);
        $user2222->assignRole('Cliente');

        Setting::updateOrCreate(['key' => 'site_name'], ['value' => 'Portal do Cliente']);
        Setting::updateOrCreate(['key' => 'mission'], ['value' => 'Entregar atendimento técnico de excelência.']);
        Setting::updateOrCreate(['key' => 'vision'], ['value' => 'Ser referência em portais de atendimento.']);
        Setting::updateOrCreate(['key' => 'values'], ['value' => 'Segurança, Agilidade, Transparência']);
    }
}
