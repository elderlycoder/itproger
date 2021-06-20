@if ($errors->any())
   <div>
      <div>
         <div>
            <div>
               <ul>
                  @foreach ($errors->all() as $error)
                     <li>{{ $error }}</li>
                  @endforeach
               </ul>
            </div>
         </div>
      </div>
   </div>
@endif