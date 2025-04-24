<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use Laravel\Sanctum\Sanctum;

class UserApiTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function retorna_lista_de_usuarios_autenticado()
    {

        User::factory()->count(3)->create();

        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->getJson('/api/users');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => ['id', 'name', 'email', 'created_at', 'updated_at'],
        ]);
    }

    /** @test */
    public function nao_permite_acesso_sem_autenticacao()
    {
        $response = $this->getJson('/api/users');

        $response->assertStatus(401); // Unauthorized
    }
}
