<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller{

   public function index(){
      $posts = DB::select("SELECT * FROM posts");
      return $posts;
   }
}