<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use \Storage;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    const IS_BANNED = 1;
    const IS_ACTIVE = 0;
    protected $fillable = ['name','email'];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts() //каждый user может иметь много постов
    {
        return $this->hasMany(Post::class);
    }
    public function comments() //каждый user может иметь много комментариев
    {
        return $this->hasMany(Comment::class);
    }
    public static function add($fields){
        $user = new static;
        $user->fill($fields); //массовое назначение
        $user->save(); 

        return $user;  
    }
    public function edit($fields){
        $this->fill($fields); // name, email
                
        $this->save();
    }
    public function generatePassword($password){
        if($password != null){
            $this->password = bcrypt($password);
            $this->save();
        }
    }

    public function remove(){
        $this->removeAvatar();
        $this->delete();
    }

    public function uploadAvatar($image)
    {   if($image == null) {return;}
        $this->removeAvatar();
        
       
        // 2) генерирует название файла
        $filename = Str::random(10) . '.' . $image->extension();
        // 3) сохраняет файл в папку uploads
        $image->storeAs('uploads', $filename);
        // закидывает значение в поле image (это значит в БД?)
        $this->avatar = $filename; //обращаемся к посту ($this) в его поле image добавляем файл картинки
        $this->save();
    }
    public function removeAvatar(){
        if($this->avatar != null){
            // 1) пришла новая картинка - удаляем предыдущую картинку
       Storage::delete('uploads/'. $this->avatar); // удаление файлов, обращаемся к классу Storage и его статическому методу delete, параметр - путь до файла
       }
    }


    public function getImage(){
        if($this->avatar == null){
            return '/img/no-user-image.png';
        }
        return '/uploads/' . $this->avatar;
    }

    public function makeAdmin(){  //назначение пользователя админом
        $this->is_admin = 1;
        $this->save();
    }
    public function makeNormal(){  //назначение пользователя не дмином
        $this->is_admin = 0;
        $this->save();
    }
    public function toggleAdmin($value){
        if($value == null){
            return $this->makeNormal();
        }
        return $this->makeAdmin();
    }
    public function ban(){  //забанить пользователя
        $this->status= User::IS_BANNED;
        $this->save();
    }
    public function unban(){  //
        $this->status = User::IS_ACTIVE;
        $this->save();
    }
    public function toggleBanned($value){
        if($value == null){
            return $this->unban();
        }
        return $this->ban();
    }
}
  