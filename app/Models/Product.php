<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{   protected $table = "ok_virtuemart_products_ru_ru"; //привязываем таблицу к модели
    protected $connection = 'mysql2';
    protected $primaryKey='virtuemart_product_id';
//метод который связывает product с price
    public function price(){
        return $this->hasOne(VmPrice::class, 'virtuemart_product_id', 'virtuemart_product_id');
    }
}
