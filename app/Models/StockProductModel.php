<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockProductModel extends Model
{
    use HasFactory;
    protected $table = 'tb_stock_product';
    protected $fillable = ['product_id', 'stock_product', 'stock_number', 'stock_type', 'stock_description'];

    public function ProductModel(){
    	return $this->belongsTo(ProductModel::class);
    }
}
