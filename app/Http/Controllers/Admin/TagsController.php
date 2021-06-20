<?php

namespace App\Http\Controllers\Admin;
use App\Models\Tag;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {// делаем запрос в базу и передаём тэги
        $tags = Tag::all();
        return view('admin/tags/index', ['tags'=>$tags]);
    }

    public function create()
    {
        return view('admin/tags/create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required'
        ]);
        Tag::create($request->all());
        return redirect()->route('tags.index');
    }


    public function edit($id)
    {
        $tag = Tag::find($id);
        return view ('admin/tags/edit', ['tag'=>$tag]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required'
        ]);
        $tag = Tag::find($id);
        $tag->update($request->all());
        return redirect()->route('tags.index');
    }

    public function destroy($id)
    {
        Tag::find($id)->delete();
        return redirect()->route('tags.index');
    }
}
