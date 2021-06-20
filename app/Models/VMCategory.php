<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VMCategory extends Model
{   protected $table = "ok_virtuemart_categories_ru_ru"; //привязываем таблицу к модели
    protected $connection = 'mysql2';
}