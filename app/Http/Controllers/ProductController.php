<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;  //подключаем модель Product
use App\Models\VmPrice;


class ProductController extends Controller{

   public function allData(){
      $product = Product::all();
      return view('products', ['data' => $product]);
   }

   public function getProductFromId($id){
      $product = Product::find($id);
      // $product = Product::where('virtuemart_product_id', '=', $id )->get();
      // $product_name = $product->first()->product_name;
      // $product_desc = $product->first()->product_desc;
      $price = VmPrice::find($id);
      // $price = VmPrice::where('virtuemart_product_id', '=', $id )->get();
      // $product_price = $price->first()->product_price;
      
      //$product_price = $product->price()->first()->product_price;
      return view('productcard', compact('product', 'price'));
   }

   public function findProductFromId($virtuemart_product_id)   {
      $product = Product::find('$virtuemart_product_id');
      return $product->product_name;
   } 
}