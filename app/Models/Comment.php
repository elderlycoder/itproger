<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public funcion post()
    {
        return $this->hasOne(Post::class);
    }
    public funcion user()
    {
        return $this->hasOne(User::class);
    }
    public function allow(){  //назначение пользователя админом
        $this->status = 1;
        $this->save();
    }
    public function disAllow(){  //назначение пользователя не дмином
        $this->status = 0;
        $this->save();
    }
    public function toggleStatus(){
        if($this->status == 0){
            return $this->allow();
        }
        return $this->disAllow();
    }
    public function remove()        
    {
        $this->delete();
    }
}
