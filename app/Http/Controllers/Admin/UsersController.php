<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin/users/index', ['users' => $users]);
    }

    public function create(){
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'avatar' => 'nullable|image' //поле не обязательное, но если оно заполнено то должно быть формата image
        ]);
        $user = User::add($request->all());
        $user->generatePassword($request->get('password'));
        $user->uploadAvatar($request->file('avatar'));

        return redirect()->route('users.index');

    }

    //выводит страницу с формой редактирования и заполненными данными пользователя
    // роут: admin/users/{id}/edit
    public function edit($id)
    { $user = User::find($id);
        return view('admin.users.edit', ['user'=>$user]);// передать можно так [compact('user')]
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $this->validate($request, [
            'name' => 'required',
            'email'=> ['required',
                        'email',
                        // правило убирающее ошибку чтобы email был уникальным при редактировании пользователя
                        Rule::unique('users')->ignore($user->id)],
            'avatar'=>'nullable|image'
        ]); 
        $user->edit($request->all()); //заменяем данные в объекте $user на данные пришедшие из запроса
        $user->generatePassword($request->get('password'));
        $user->uploadAvatar($request->file('avatar'));

        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->remove();
        return redirect()->route('users.index');
    }
}
