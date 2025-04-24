<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use App\Models\Product;
use Inertia\Inertia;

class ProdutoController extends Controller
{
    public function editar($id)
    {
        $produto = Product::findOrFail($id);

        return Inertia::render('EditProduto', [
            'produto' => $produto,
            'user_id' => Auth::id(),
            'id' => $produto->id,
        ]);
    }

    public function atualizar(Request $request, $id)
    {
        $produto = Product::findOrFail($id);

        $produto->update($request->validate([
            'title' => 'required|string',
            'price_sale' => 'required|numeric',
            'price_cost' => 'required|numeric',
            'description' => 'nullable|string',
            'active' => 'boolean',
        ]));

        return redirect()->route('produtos');
    }
}
