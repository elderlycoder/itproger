<?php

use Illuminate\Support\Facades\Route;



// Route::get('contact', function(){ //хотим попасть на страницу методом GET, т.е. введя URL в адресную строку
//     return view('contact');
// });

// Route::post('sendemail', function(){
//     return view('sendemail');
// });
//другой вариант использовать метод match
Route::get('/blog', 'HomeController@index');
Route::get('/post/{slug}', 'HomeController@show')->name('post.show');
Route::get('/tag/{slug}', 'HomeController@tag')->name('tag.show'); //вывод по тегу
Route::get('/category/{slug}', 'HomeController@category')->name('category.show');//вывод по категории
Route::get('/', function(){return view('home');})->name('home');
Route::group(['prefix'=>'admin', 'namespace'=>'Admin'], function(){
    Route::get('/', 'DashboardController@index');
    Route::resource('/categories', 'CategoriesController');
    Route::resource('/tags', 'TagsController');
    Route::resource('/users', 'UsersController');
    Route::resource('/posts', 'PostsController');

}); 

Route::get('about', function(){return view('about');})->name('about');

Route::get('contact', function(){
    return view('contact');
})->name('contact');
Route::get('/product/all', 'ProductController@allData')->name('products-list');
Route::get('/product/{id}', 'ProductController@getProductFromId')->name('product-from-id');
Route::get('/contact/all', 'ContactController@allData')->name('contact-data');
Route::post('/contact/submit', 'ContactController@submit')->name('contact-form');
Route::get('/contact/{id}', 'ContactController@findContact')->name('contact-find');







// Route::match(['post', 'get'], 'contact', function(){
//     if(!empty($_POST)){
//         dump($_POST);
//     }
//     return view('contact');
// });

//Обязательный параметр
