<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Models\Product;

class ProductApiTest extends TestCase
{
    use RefreshDatabase;

    protected function authenticate()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');
        return $user;
    }

    /** @test */
    public function retorna_lista_de_produtos()
    {
        $this->authenticate();

        Product::factory()->count(3)->create();

        $response = $this->getJson('/api/products');

        $response->assertStatus(200)
                 ->assertJsonCount(3);
    }

    /** @test */
    public function cria_um_novo_produto()
    {
        $user = $this->authenticate();

        $dados = [
            'title' => 'Novo Produto',
            'price_sale' => 120.00,
            'price_cost' => 90.00,
            'description' => 'Descrição teste',
            'images' => json_encode(['imagem1.jpg']),
            'active' => true,
            'acao' => 'Criação',
            'user_id' => $user->id, 
        ];

        $response = $this->postJson('/api/products', $dados);

        $response->assertStatus(201);
        $this->assertDatabaseHas('products', ['title' => 'Novo Produto']);
    }

    /** @test */
    public function atualiza_um_produto_existente()
    {
        $user = $this->authenticate();

        $produto = Product::factory()->create([
            'title' => 'Antigo Título',
        ]);

        $dadosAtualizados = [
            'title' => 'Novo Título',
            'price_sale' => $produto->price_sale,
            'price_cost' => $produto->price_cost,
            'description' => $produto->description,
            'images' => $produto->image,
            'active' => $produto->active,
            'acao' => 'Edição',
            'user_id' => $user->id,
        ];

        $response = $this->putJson("/api/products/{$produto->id}", $dadosAtualizados);

        $response->assertStatus(200);
        $this->assertDatabaseHas('products', ['title' => 'Novo Título']);
    }

    /** @test */
    public function ativa_ou_inativa_um_produto()
    {
        $this->authenticate();

        $produto = Product::factory()->create(['active' => true]);

        $response = $this->patchJson("/api/products/{$produto->id}/toggle", [
            'active' => false
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('products', [
            'id' => $produto->id,
            'active' => false,
        ]);
    }
}
