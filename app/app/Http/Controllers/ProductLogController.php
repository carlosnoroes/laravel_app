<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProdutoLog;
use Inertia\Inertia;

class ProductLogController extends Controller
{
    public function index()
    {
        $logs = ProdutoLog::with(['user', 'product'])
            ->latest()
            ->get()
            ->map(function ($log) {
                return [
                    'id' => $log->id,
                    'product_title' => optional($log->product)->title,
                    'user_name' => optional($log->user)->name,
                    'acao' => $log->acao,
                    'data' => $log->created_at->format('d/m/Y H:i:s')
                ];
            });

        return Inertia::render('LogsProdutos', [
            'logs' => $logs
        ]);
    }
}
