<?php

namespace App\Http\Controllers\Admin;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index(){
        $categories = Category::all(); // получаем все категории из БД через модель Category и сохраняем их в переменную $categories
        return view('admin.categories.index', compact('categories'));
    }

    public function create(){ //метод просто возвращает вид с формой
        return view('admin.categories.create');
    }

    public function store(Request $request){
        $this->validate($request, ['title' => 'required']);
        Category::create($request->all());
        return redirect()->route('categories.index');
    }

    public function edit($id){
        $category = Category::find($id);
        return view('admin.categories.edit', ['category'=>$category]);
    }

    public function update(Request $request, $id){
        $this->validate($request, ['title' => 'required']);
        $category = Category::find($id);
        $category->update($request->all());
        return redirect()->route('categories.index');
    }

    public function destroy($id)
    {
        Category::find($id)->delete();
        return redirect()->route('categories.index');
    }
}
