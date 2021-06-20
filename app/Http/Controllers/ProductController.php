<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;  //подключаем модель Product


class ProductController extends Controller{

   public function allData(){
      $product = Product::all();

      return view('products', ['data' => $product]);
   }

   public function getProductFromId($id){
      $products = Product::where('virtuemart_product_id', '<=', $id )->get();
      return view('products', ['data' => $products]);
   }

   public function findProductFromId($virtuemart_product_id)   {
      $product = Product::find('$virtuemart_product_id');
      return $product->product_name;
   } 
}