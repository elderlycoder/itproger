<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Contact;  //подключаем модель Contact
use App\Http\Requests\ContactRequest; // подключаем класс (по сути файл) валидации

class ContactController extends Controller{

   public function submit(ContactRequest $req){

      $contact = new Contact(); //создаём объекм на основе модели (класса) Contact
      $contact->name = $req->input('name'); 
      $contact->email = $req->input('email'); 
      $contact->subject = $req->input('subject'); 
      $contact->message = $req->input('message'); 

      $contact->save();

      return redirect()->route('home')->with('success', 'Сообщение успешно!');
      
   }

   // public function allData(){ // экшен для получения всех сообщений, сообщения получаем из таблицы Contact, поэтому взаимодействуем с моделью Contact
   //    $contact = new Contact; //создаём объект модели (класса) Contact, т.к. никаких параметров не передаём то Contact() можно записать как Contact 
   //    dd($contact->all());

   public function allData(){
      return view('messages', ['data' => Contact::all() ]);
   }

   public function findContact($id)   {
      $contact = Contact::find(2);
      return $contact->subject;
   } 
   
}