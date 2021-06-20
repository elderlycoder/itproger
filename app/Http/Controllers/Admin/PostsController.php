<?php

namespace App\Http\Controllers\Admin;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PostsController extends Controller
{
   
    public function index()
    {
        $posts = Post::all();
        return view('admin.posts.index', ['posts'=>$posts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   //выбрать все теги из них взять только поля id и title в виде массива
        $categories = Category::pluck('title', 'id')->all();
        $tags = Tag::pluck('title', 'id')->all();
        return view('admin.posts.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {   
        $this->validate($request, [
            'title'=>'required',
            'content'=>'required',
            'date'=>'required',
            'image'=>'nullable|image',

        ]);
       //dd($request->get('tags'));
        $post = Post::add($request->all());//возвращает экземпляр класса, заполненный указанными данными, в нашем случае title и content
        $post->uploadImage($request->file('image'));
        $post->setCategory($request->get('category_id'));// установить категорию, в качестве аргумента данные из формы, поле с именем 'category_id'
        $post->setTags($request->get('tags'));
        $post->toggleStatus($request->get('status'));
        $post->toggleFeatured($request->get('is_featured'));

        return redirect()->route('posts.index');

    }

    public function edit($id)
    {
        $post = Post::find($id);
        //pluck извлекает из коллекции все значения по атрибуту 'title'  и возвращает массив с ключами 'id'
        $categories = Category::pluck('title', 'id')->all();
        //dd($categories);
        $tags = Tag::pluck('title', 'id')->all();
        return view('admin.posts.edit', compact('categories', 'tags', 'post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return $id;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
