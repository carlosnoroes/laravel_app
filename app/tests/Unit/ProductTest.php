<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Product;

class ProductTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */

    /** @test */
    public function pode_criar_e_deletar_um_produto()
    {
        // Criando o produto
        $produto = Product::factory()->create([
            'title' => 'Produto Teste 01',
            'price_sale' => 100,
            'price_cost' => 70,
            'description' => 'Um produto de teste',
            'image' => json_encode(['imagem.jpg']),
            'active' => true,
        ]);

        // Verificando se foi salvo corretamente
        $this->assertDatabaseHas('products', [
            'title' => 'Produto Teste 01',
            'price_sale' => 100,
        ]);

        // Deletando o produto
        $produto->delete();

        // Verificando que foi removido da base
        $this->assertDatabaseMissing('products', [
            'title' => 'Produto Teste',
        ]);
    }
}
