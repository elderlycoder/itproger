<?php
namespace App\Http\Controllers;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller{

   public function index(){
      $posts = Post::paginate(3); //выводить по 3 поста
      return view('pages.index', ['posts' => $posts]);
   }

   public function show($slug){// slug - параметр получаемый из маршрута к которому привязан метод контроллера, часто используют одинаковые имена в названии параметра маршрута и и названии аргумента метода, но это не обязательно
      $post = Post::where('slug', $slug)//берем запись из БД где значение в столбце 'slug' равняется    $slug
               ->firstOrFail();//вытащить элемент или вытащить ошибку
      return view('pages.show', compact('post'));
   }
}