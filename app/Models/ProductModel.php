<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductModel extends Model
{
    use HasFactory;
    protected $table = 'tb_product';
    protected $fillable = ['product_name', 'product_description', 'product_price'];

    public function StockProductModel(){
    	return $this->hasMany(StockProductModel::class);
    }
}
