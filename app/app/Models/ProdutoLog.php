<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdutoLog extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'product_id',
        'user_id',
        'acao',
    ];

    public function produto()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
