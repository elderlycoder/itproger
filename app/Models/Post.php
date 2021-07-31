<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Post extends Model{  
    protected $fillable = ['title', 'content', 'date', 'description'];
    use Sluggable;
    const IS_DRAFT = 0;
    const IS_PUBLIC = 1;    
    // связь для тэгов
    public function tags(){
        return $this->belongsToMany(Tag::class);
    }
    
    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function author(){
        return $this->belongsTo(User::class, 'user_id');// указываем что связываем модели по полю 'user_id', потому что по умолчанию laravel будет искать поле 'author_id'
    }

    public function sluggable()
    {
        return['slug' => ['source' => 'title']];
    }
    //добавление нового поста, аргумент какой-то массив параметров fields (title и content)
    public static function add($fields)
    {
        $post = new static; //создаём экземпляр класса
        $post->fill($fields); //заполняем нужными данными с помощью массового присвоения
        $post->user_id = 1;
        $post->save();
        return $post;
    }
    // изменение статьи
    public function edit($fields)
    {
        $this->fill($fields); 
        $this->save();
    }
    // удаление статьи
    public function remove()
    {   
        $this->removeImage();
        $this->delete();
    }
    public function removeImage(){
        if($this->image != null){
            // 1) пришла новая картинка - удаляем предыдущую картинку
        Storage::delete('uploads/'. $this->image); // удаление файлов, обращаемся к классу Storage и его статическому методу delete, параметр - путь до файла
        }
    }
    // добавить картинку к статье
    public function uploadImage($image)
    {   if($image == null) {return;}
        
        $this->removeImage();
        // 2) генерирует название файла
        $filename = Str::random(10) . '.' . $image->extension();
        // 3) сохраняет файл в папку uploads
        $image->storeAs('uploads', $filename);
        // закидывает значение в поле image (это значит в БД?)
        $this->image = $filename; //обращаемся к посту ($this) в его поле image добавляем файл картинки
        $this->save();
    }
    public function getImage(){
        if($this->image == null){
            return '/img/no-image.png';
        }
        return '/uploads/' . $this->image;
    }
    // метод привязка к категории
    public function setCategory($id){
        if($id == null){return;}
        $this->category_id = $id;
        $this->save();
    }
    // метод привязка тэга, делаем через связь Laravel
    public function setTags($ids){
        if($ids == null){return;}
        $this->tags()->sync($ids);
    }
    // установка статуса поста - "Черновик"
    public function setDraft()
    {
        $this->status = Post::IS_DRAFT;
        $this->save();
    }
    // установка статуса поста - "Опубликовано"
    public function setPublic()
    {
        $this->status = Post::IS_PUBLIC;
        $this->save();
    }
    // переключатель статуса поста
    public function toggleStatus($value)
    {
    if($value == null){
        return $this->setDraft();
    }
    else{
        return $this->setPublic();
    }}
    // установка статуса поста - "Рекомендовано"
    public function setFeatured()
    {
        $this->is_featured = 0;
        $this->save();
    }
    // установка статуса поста - "Стандарт" (обычный не рекомендованный пост)
    public function setStandart()
    {
        $this->is_featured = 1;
        $this->save();
    }
    // переключатель статуса поста
    public function toggleFeatured($value)
    {
    if($value == null){
        return $this->setStandart();
    }
    else{
        return $this->setFeatured();
    }
    }
    public function setDateAttribute($value){//получаем значение инпута 'date'
        $date = Carbon::createFromFormat('d/m/y', $value)->format('Y-m-d');
        $this->attributes['date'] = $date;
    }
    public function getDateAttribute($value){//получаем значение инпута 'date'
        $date = Carbon::createFromFormat('Y-m-d', $value)->format('d/m/y');
        return $date;
    }

    public function getCategoryTitle(){
        if($this->category !=null){
            return $this->category->title;
        }

        return 'Нет категории';
    }

    public function getTagsTitle(){
        if(!$this->tags->isEmpty()){
            return implode(', ', $this->tags->pluck('title')->all());
        }        
        return 'Нет тегов';
    }

    public function getDate(){ //преобразуем формат даты из текущего 08/09/20 в Сентябрь 8, 2020
       return  Carbon::createFromFormat('d/m/y', $this->date)->format('F d, Y');
    }

    public function hasPrevious(){  //возвращает наибольший id поста перед текущим
        // вместо self можно использовать Post
        return self::where('id', '<', $this->id)->max('id');
    }

    public function getPrevious(){
        $postID = $this->hasPrevious();
            return self::find($postID);
        }

    public function hasNext(){
        return self::where('id', '>', $this->id)->min('id');
    }

    public function getNext(){
        $postID = $this->hasNext();
            return self::find($postID);
        }

    public function related(){
        return  self::all()->except($this->id); //вернуть все посты кроме текущего
    }
}

