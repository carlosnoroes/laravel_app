<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\ProdutoLog;

class ProductController extends Controller
{
    public function index()
    {
        $product = Product::orderBy('id', 'desc')->get();
        return response()->json($product, 200);
    }

    public function store(Request $request)
    {
        #dd($request->all());
        $dados = $this->validaDadosProduto($request);

        $produto = Product::create($dados);

         ProdutoLog::create([
            'product_id' => $produto->id,
            'user_id' => $request->user_id,
            'acao' => $request->acao,
        ]);

        return response()->json($produto, 201);
    }

    public function update(Request $request, $id)
    {
        $produto = Product::findOrFail($id);

        $dados = $this->validaDadosProduto($request);

        $produto->update($dados);

        ProdutoLog::create([
            'product_id' => $produto->id,
            'user_id' => $request->user_id,
            'acao' => $request->acao,
        ]);

        return response()->json([
            'message' => 'Produto atualizado com sucesso!'
        ]);
    }

    public function toggle($id)
    {
        $product = Product::findOrFail($id);
        $product->active = !$product->active;
        $product->save();

        return $product;
    }

    private function validaDadosProduto(Request $request)
    {

        $dados = $request->validate([
            'title' => 'required|string',
            'price_sale' => 'required|numeric',
            'price_cost' => 'required|numeric',
            'description' => 'nullable|string',
            'active' => 'boolean',
            'acao' => 'required|string|in:Criação,Edição',
            'user_id' => 'required|exists:users,id',
            'acao' => 'required|string|in:Criação,Edição',
            'image.*' => 'nullable|image|mimes:jpeg,png|max:2048'
        ]);

        if (!empty($dados['description'])) {
            $dados['description'] = strip_tags($dados['description'], '<p><br><b><strong>');
        }

        $paths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $paths[] = $image->store('produtos', 'public');
            }
        }

        $dados['image'] = json_encode($paths);

        $precoMinimo = round($dados['price_cost'] * 1.1, 2);
        if ($dados['price_sale'] < $precoMinimo) {
            return response()->json([
                'message' => 'O preço de venda deve ser superior ou igual a 110% do custo.'
            ], 422);
        }

        return $dados;
    }
}
